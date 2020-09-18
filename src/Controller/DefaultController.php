<?php


namespace App\Controller;


use Core\Controller\AController;

class DefaultController extends AController
{
    public function indexAction()
    {
        $this->render('default/index.html.twig', [
            'test' => "TEST"
        ]);
    }
}