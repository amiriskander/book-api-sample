<?php

namespace AppBundle\Controller\Api;

use AppBundle\Consumer\CreateBookConsumer;
use AppBundle\Document\Book;
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
     * @Rest\Get("/insert", name="book_api_insert")
     */
    public function insertAction(Request $request)
    {
//        $consumer = new CreateBookConsumer();
//        $consumer->listen();
//        die;
        $book = new Book();
        $book->setName('Test Book 001');
        $book->setAuthor('Amir Iskander');
        $book->setYear(2012);
        $book->setIsbn('1231231231231');

        $manager = $this->get('es.manager');
        // $repo = $manager->getRepository('AppBundle:Book');
        // $repo = $this->get('es.manager.default.book');
        $manager->persist($book);
        $manager->commit();





        // dump($book); die;
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($book);
//        $em->flush();
//        $finder = $this->get('foq_elastica.finder.library.book');
//        // $searchTerm = $request->query->get('search');
//        $searchTerm = 'Amir';
//        $sites = $finder->find($searchTerm);
//        dump($sites); die;
//        return array('sites' => $sites);
    }
}
