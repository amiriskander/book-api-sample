<?php

namespace AppBundle\Controller\Api;

use AppBundle\Service\Rabbitmq;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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

        // $this->container->get('\AppBundle\Service\Rabbitmq')->enqueue($bookData);
        $this->container->get(Rabbitmq::class)->enqueue($bookData);

        die;
    }

}
