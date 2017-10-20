<?php

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ES\Document(type="book")
 */
class Book
{
    /**
     * @ES\Id()
     */
    private $id;

    /**
     * @ES\Property(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $name;

    /**
     * @ES\Property(type="keyword")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $author;

    /**
     * @ES\Property(type="date")
     */
    private $year;

    /**
     * @ES\Property(type="keyword")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 13,
     *     max = 13,
     *     exactMessage = "Book ISBN must be 13 characters long."
     * )
     */
    private $isbn;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = new \DateTime();
        $this->year->setDate($year, 1, 1);
        return $this;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
        return $this;
    }
}
