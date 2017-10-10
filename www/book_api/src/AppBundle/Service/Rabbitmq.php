<?php

namespace AppBundle\Service;

class Rabbitmq
{
    public function __construct()
    {
    }

    public function enqueue($data)
    {
        $this->get('old_sound_rabbit_mq.upload_picture_producer')->publish(serialize($msg));
        dump($data); die;
        // a
    }
}
