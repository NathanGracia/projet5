<?php

namespace App\Model\Entity;

use App\Repository\UserRepository;
class Comment
{
    
    private $id;
    
    private $id_author;
    
    private $created_at;
    
    private $content;
    
    private $slug;
    
    private $title;

    private $id_article;

    private $date;

    private $approved;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @param mixed $approved
     */
    public function setApproved($approved): void
    {
        $this->approved = $approved;
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
    public function getId_author()
    {
        return $this->id_author;
    }

    /**
     * @param mixed $id_author
     */
    public function setId_author($id_author): void
    {
        $this->id_author = $id_author;
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
    public function getId_article()
    {
        return $this->id_article;
    }

    /**
     * @param mixed $id_article
     */
    public function setId_article($id_article): void
    {
        $this->id_article = $id_article;
    }

    public function getAuthor(){
        if(empty($this->author)){
            $userRepository = new UserRepository();
            $this->author =  $userRepository->findOneBy(['id'=> $this->getId_author()]);
        }

        return $this->author;
    }


    
 


    
 
}