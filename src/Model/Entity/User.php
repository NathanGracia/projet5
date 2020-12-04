<?php

namespace App\Model\Entity;

class User
{
    
    private $id;
    
    private $name;
    
    private $password;
    
    private $email;
    






    
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
    public function getname()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setname($name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $content
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

   


    
 
}