<?php


namespace App\Controller;


use Core\Controller\AController;
use Core\Model\DB;
use  App\Model\Entity\Article;


class ArticleController extends AController
{
    public function showAction($param)
    {
        $slug = $param["slug"];
        //nouvelle connexion à la db
        $db =  DB::getInstance();
        //query select * 
        $result = $db->findWhere(Article::getTable(), [
            'slug' => $slug
        ]);
  
        if(!is_null($result)){

            $id = $result[0]['id'];
            $author = null;
            $created_at = null;
            $content = $result[0]['content'];
            $slug = $result[0]['slug'];
            $title = $result[0]['title'];

            $article = new Article($id, $author, $created_at, $content, $slug, $title);
      

          
            $this->render('article/show.html.twig', [
                "article" => $article,
            ]);
        }else{
            $this->render('404.html.twig');
        }
    

       
        
    }

    public function indexAction(){

        $db =  DB::getInstance();
        $articles = $db->findAll('article');
        $this->render('article/index.html.twig',[
            'articles' =>$articles
        ]);
    }
}