<?php

namespace AppBundle\Service;

class CreateBook
{
    private $producer;

    public function __construct($producer)
    {
        $this->producer = $producer;
    }

    public function enqueue($book)
    {
        $this->producer->publish($book);
    }
}
