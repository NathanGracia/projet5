<?php

namespace App\Model\Entity;

class Book
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $author;
    /**
     * @var
     */
    private $id;

    /**
     * Book constructor.
     * @param $name
     * @param $author
     * @param $id
     */
    public function __construct($name, $author, $id)
    {
        $this->name = $name;
        $this->author = $author;
        $this->$id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

}