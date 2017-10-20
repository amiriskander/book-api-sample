<?php
namespace AppBundle\Consumer;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Elasticsearch\ClientBuilder;

class CreateBookConsumer
{
    /**
     * Process incoming request to generate pdf invoices and send them through
     * email.
     */
    public function listen()
    {
        $connection = new AMQPConnection('rabbit', 5672, 'rabbit', 'mq');
        $channel = $connection->channel();

        $channel->queue_declare(
            'create_book', #queue
            false,         #passive
            true,          #durable, make sure that RabbitMQ will never lose our queue if a crash occurs
            false,         #exclusive - queues may only be accessed by the current connection
            false          #auto delete - the queue is deleted when all consumers have finished using it
        );

        /**
         * don't dispatch a new message to a worker until it has processed and
         * acknowledged the previous one. Instead, it will dispatch it to the
         * next worker that is not still busy.
         */
        $channel->basic_qos(
            null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
            1,      #prefetch count - prefetch window in terms of whole messages
            null    #global - global=null to mean that the QoS settings should apply per-consumer, global=true to mean that the QoS settings should apply per-channel
        );

        /**
         * indicate interest in consuming messages from a particular queue. When they do
         * so, we say that they register a consumer or, simply put, subscribe to a queue.
         * Each consumer (subscription) has an identifier called a consumer tag
         */
        $channel->basic_consume(
            'create_book',        #queue
            '',    #consumer tag - Identifier for the consumer, valid within the current channel. just string
            false, #no local - TRUE: the server will not send messages to the connection that published them
            false, #no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
            false, #exclusive - queues may only be accessed by the current connection
            false, #no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
            array($this, 'process') #callback
        );

        while (count($channel->callbacks)) {
            // $this->log->addInfo('Waiting for incoming messages');
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    /**
     * process received request
     *
     * @param AMQPMessage $msg
     */
    public function process(AMQPMessage $msg)
    {
        // $this->generatePdf()->sendEmail();
        dump($msg);

        $params = [
            'index' => 'books',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => $msg
        ];

        $client = ClientBuilder::create()->build();

        $response = $client->index($params);

        /**
         * If a consumer dies without sending an acknowledgement the AMQP broker
         * will redeliver it to another consumer or, if none are available at the
         * time, the broker will wait until at least one consumer is registered
         * for the same queue before attempting redelivery
         */
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        dump($response);
    }

    /**
     * Generates invoice's pdf
     *
     * @return CreateBookConsumer
     */
    private function generatePdf()
    {
        /**
         * Mocking a pdf generation processing time.  This will take between
         * 2 and 5 seconds
         */
        sleep(mt_rand(2, 5));
        return $this;
    }

    /**
     * Sends email
     *
     * @return CreateBookConsumer
     */
    private function sendEmail()
    {
        /**
         * Mocking email sending time.  This will take between 1 and 3 seconds
         */
        sleep(mt_rand(1, 3));
        return $this;
    }
}
