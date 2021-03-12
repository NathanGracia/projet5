<?php


namespace App\Controller;


use Core\Controller\AController;

class DefaultController extends AController
{
    public function index()
    {
        $this->displayRender('index.html.twig');
    }
}