<?php


namespace App\Controller;


use Core\Controller\AController;
use Core\Model\DB;
use  App\Model\Entity\Article;
use App\Repository\ArticleRepository;


class ArticleController extends AController
{
   /**
     * @var ArticleRepository
     */
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }


    public function showAction($param)
    {
        $slug = $param["slug"];
       
        //query select * 
        $article =  $this->articleRepository->findOneBy(['slug'=>$slug]);
      
    
  
        if(!is_null($article)){

            $id = $article['id'];
            $author = null;
            $created_at = null;
            $content = $article['content'];
            $slug = $article['slug'];
            $title = $article['title'];

            $article = new Article($id, $author, $created_at, $content, $slug, $title);
      

          
            $this->render('article/show.html.twig', [
                "article" => $article,
            ]);
        }else{
            $this->render('404.html.twig');
        }
    

       
        
    }

    public function indexAction(){

      
        $articles =  $this->articleRepository->findAll();
        $this->render('article/index.html.twig',[
            'articles' =>$articles
        ]);
    }
}