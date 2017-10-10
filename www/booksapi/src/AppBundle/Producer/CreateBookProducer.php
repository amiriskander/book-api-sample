<?php

namespace AppBundle\Producer;

class CreateBookProducer
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
