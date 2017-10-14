<?php

namespace AppBundle\Controller\Api;

use AppBundle\Consumer\CreateBookConsumer;
use AppBundle\Producer\CreateBookProducer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PhpAmqpLib\Connection\AMQPConnection;

/**
 * @Route("/api/book")
 */
class BookController extends FOSRestController
{
    /**
     * @Rest\Post("/", name="book_api_create")
     */
    public function createAction(Request $request)
    {
        /*$params = array(
            'host' => 'rabbit',
            'port' => 5672,
            'username' => 'rabbit',
            'password' => 'mq',
            'vhost' => '/'
        );

        $connection = new AMQPConnection(
            $params['host'],
            $params['port'],
            $params['username'],
            $params['password'],
            $params['vhost']
        );

        dump($connection->isConnected());

        dump($connection); die;*/

        $bookData = $request->request->all();

//        dump($bookData);
//        die;
        // $this->container->get('\AppBundle\Service\Rabbitmq')->enqueue($bookData);
        // $this->container->get(Rabbitmq::class)->enqueue($bookData);

        // dump( class_exists(CreateBookProducer::class) ); die;

        // $this->get('create_book')->enqueue(serialize($bookData));
        // $this->get('old_sound_rabbit_mq.create_book_producer')->publish(serialize($bookData));

        $producer = new CreateBookProducer();
        $producer->enqueue($bookData);

        die;

    }

    /**
     * @Rest\Get("/search", name="book_api_search")
     */
    public function searchAction(Request $request)
    {
        $consumer = new CreateBookConsumer();
        $consumer->listen();
        die;
//        $finder = $this->get('foq_elastica.finder.library.book');
//        // $searchTerm = $request->query->get('search');
//        $searchTerm = 'Amir';
//        $sites = $finder->find($searchTerm);
//        dump($sites); die;
//        return array('sites' => $sites);
    }
}
