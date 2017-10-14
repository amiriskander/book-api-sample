<?php

namespace AppBundle\Producer;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CreateBookProducer
{
    /*private $producer;

    public function __construct($producer)
    {
        $this->producer = $producer;
    }*/

    public function enqueue($book)
    {
        // $this->producer->publish($book);
        $connection = new AMQPConnection('rabbit', 5672, 'rabbit', 'mq');
        $channel = $connection->channel();

        $channel->queue_declare(
            'create_book', #queue - Queue names may be up to 255 bytes of UTF-8 characters
            false, #passive - can use this to check whether an exchange exists without modifying the server state
            true,  #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
            false, #exclusive - used by only one connection and the queue will be deleted when that connection closes
            false  #auto delete - queue is deleted when last consumer unsubscribes
        );

        $msg = new AMQPMessage(
            json_encode($book),
            array('delivery_mode' => 2) # make message persistent, so it is not lost if server crashes or quits
        );

        $channel->basic_publish(
            $msg,               #message
            '',                 #exchange
            'create_book'     #routing key (queue)
        );

        $channel->close();
        $connection->close();
    }
}
