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
        $bookData = $request->request->all();
        $producer = new CreateBookProducer();
        $producer->enqueue($bookData);

        die;

    }

    /**
     * @Rest\Get("/insert", name="book_api_insert")
     */
    public function insertAction(Request $request)
    {
        $consumer = new CreateBookConsumer();
        $consumer->listen();
        die;


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
    }
}
