<?php


namespace App\Controller;


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
}