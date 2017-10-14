<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ORM\Entity
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\MaxLength(255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\MaxLength(255)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=13)
     * @Assert\NotBlank()
     * @Assert\MaxLength(13)
     */
    private $isbn;
}
