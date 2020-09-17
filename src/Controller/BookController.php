<?php


namespace App\Controller;


use App\Model\Entity\Book;
use Core\Controller\AController;

class BookController extends AController
{
    public function listAction()
    {
        $this->render('book/list.html.twig');
    }

    public function showAction()
    {
        $this->render('book/show.html.twig');
    }

    public function bookInfoAction($bookNumber){

        if(!empty($bookNumber)){
            //bdd to get book data
            $name = "Le nom du livre";
            $author = "JC";

            $book = new Book($name, $author, $bookNumber) ;
            $this->render('book/bookInfo.html.twig',array(
                'book' => $book
            ) );
        }else{
            die('no book id');
        }

    }
}