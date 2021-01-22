<?php


namespace App\Controller;


use Core\Controller\AController;
use App\Model\Entity\Contact;
use Core\Form\Constraint\NotEmptyConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\TextType;
class ContactController extends AController
{
    public function contactForm()
    {

        

        $contact = new Contact();

        $form = new Form([
            'name' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'subject' => new TextType(),
            'mail' => new TextType(),
            'content' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ])
            ],$contact);

        $form->handleRequest();
     
        if ($form->isSubmitted() && $form->isValid()) {
      
            $mail = $contact->getMail();
            $name = $contact->getName();
            $content = $contact->getContent();
            $contact->sendMail($mail, $name, $content);

            var_dump("mail envoyé ?");die;
        }

          
        $this->render('contact.html.twig');
    }
}