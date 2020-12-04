<?php

namespace App\Model\Entity;

class Contact
{
    
    private $id;
    
    private $name;
    
    private $created_at;
    
    private $subject;
    
    private $mail;
    
    private $content;








    
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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

        /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
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


 
    public function sendMail(){
        // Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
        ->setUsername('nathan.gracia.863@gmail.com')
        ->setPassword('unqdljjregvmadvf')
        ;

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
        ->setFrom(['nathan.gracia.863@gmail.com' => 'Le Boss'])
        ->setTo(['nathan.gracia.863@gmail.com'])
        ->setBody('Here is the message itself')
        ;

        // Send the message
        $result = $mailer->send($message);
    }

    
 
}