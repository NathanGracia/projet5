<?php


namespace App\Controller;


use Core\Controller\AController;
use Core\Model\DB;
use  App\Model\Entity\Article;


class ArticleController extends AController
{
    public function showAction()
    {
        //nouvelle connexion à la db
        $db = new DB();
        //query select * 
        $result = $db->findAll('article');
      
        //on prend le premier resultat car par encore de slug
        $title = $result[0]['title'];
        $content = $result[0]['content'];

        $this->render('article/show.html.twig', [
            "title" => $title,
            "content" => $content
        ]);
        
    }
}