<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ORM\Entity
 */
class Book
{
    private $name;

    private $author;

    private $year;

    private $isbn;
}
