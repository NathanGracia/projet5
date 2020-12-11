<?php

namespace App\Model\Entity;

class Article
{
    
    private static $table  = "article";
    private $id;
    
    private $idAuthor;
    
    private $created_at;
    
    private $content;

    private $image_url;
    
    private $slug;
    
    private $title;






    
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
    public function getIdAuthor()
    {
        return $this->idAuthor;
    }

    /**
     * @param mixed $idAuthor
     */
    public function setIdAuthor($idAuthor): void
    {
        $this->idAuthor = $idAuthor;
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

     /**
     * @return mixed
     */
    public function getImage_url()
    {
        return $this->image_url;
    }

    /**
     * @param mixed $image_url
     */
    public function setImage_url($image_url): void
    {
        $this->image_url = $image_url;
    }
    
     /**
     * @return mixed
     */
    public static function  getTable()
    {
        return self::$table;
    }

    /**
     * @param mixed $table
     */
    public static function setTable($table): void
    {
        self::$table = $table;
    }


    
 
}