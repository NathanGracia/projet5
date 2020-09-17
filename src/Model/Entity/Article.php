<?php

namespace App\Model\Entity;

class Article
{
    
    private $id;
    
    private $author;
    
    private $created_at;
    
    private $content;
    
    private $slug;
    
    private $title;





    /**
     * Book constructor.
     * @param $id
     * @param $author
     * @param $created_at
     * @param $content
     * @param $slug
     * @param $title
     */


    public function __construct($id, $author, $created_at, $content, $slug, $title)
    {
        $this->id = $id;
        $this->author = $author;
        $this->$created_at = $created_at;
        $this->$content = $content;
        $this->$slug = $slug;
        $this->$title = $title;
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
        $this->name = $id;
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
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreated_at($created_at): void
    {
        $this->created_at = $created_at;
    }
    
    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }
    
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }
    
    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }
    
 
}