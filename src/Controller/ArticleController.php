<?php


namespace App\Controller;


use Core\Controller\AController;
use Core\Model\DB;
use  App\Model\Entity\Article;
use  App\Model\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Core\Form\Constraint\NotEmptyConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\TextType;



class ArticleController extends AController
{
   /**
     * @var ArticleRepository
     */
    private  $articleRepository;
     /**
     * @var CommentRepository
     */
    private  $commentRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->commentRepository = new CommentRepository();
    }
    


    public function showAction($param)
    {
        $slug = $param["slug"];
       
        //query select * 
        $result =  $this->articleRepository->findOneBy(['slug'=>$slug]);
        if(empty($result)){
            die('Article introuvable');
        }
        $bddComments =  $this->commentRepository->findBy(['id_article'=> $result['id']]); 
    
   
        if(!is_null($result)){

            //article :
            $article = new Article();

            $article->setId($result['id']);
            $article->setAuthor(null);
            $article->setCreated_at(null);
            $article->setContent($result['content']);
            $article->setSlug($result['slug']);
            $article->setTitle($result['title']);
            $article->setImage_url($result['image_url']);

               //commentaires :
               $comments = [];
            foreach($bddComments as $comment){

                $comment = new Comment();

                $comment->setId($comment['id']);
                $comment->setId_author($comment['id_author']);
                $comment->setContent($comment['content']);
                $comment->setCreated_at($comment['created_at']);
                $comment->setId_article($comment['id_article']);
               
                array_push($comments, $comment);
            }


          
            $this->render('article/show.html.twig', [
                "article" => $article,
                "comments" => $comments
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

    public function new(){
        $this->render('article/new.html.twig');
    }

    public function create(){
       /*  $content = htmlspecialchars( $_POST['content']);
        $title = htmlspecialchars($_POST['title']);
        $image_url = htmlspecialchars($_POST['image_url']);

        $slug = str_replace(" ", "-", $title);

        if(!empty($title) && !empty($content)){
            $this->articleRepository->insert([
           
                'content' => $content,
                'image_url' => $image_url,
                'title' => $title,
                'slug' => $slug

            ]);
            header('Location: /articles'); 
        } */

        $article = new Article();

        $form = new Form([
            'title' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'image_url' => new TextType(),
            'content' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ])
        ], $article);

        $form->handleRequest();
     
        if ($form->isSubmitted() && $form->isValid()) {

            $slug = strtolower(str_replace(" ", "-", $article->getTitle()));
            $article->setSlug($slug);

            if(empty($article->getImage_url())){
                $defaultImageUrl = "https://www.trekmag.com/media/news/2018/12/DSCF0620.jpg";
                $article->setImage_url($defaultImageUrl);
            }
           
            //envoie en bdd
            $this->articleRepository->insert([
           
                'content' => $article->getContent(),
                'image_url' => $article->getImage_url(),
                'title' => $article->getTitle(),
                'slug' => $article->getSlug()

            ]);
         
             header('Location: /article/'.$slug); 
        }
        $this->render('article/new.html.twig', [
            'form' => $form
        ]);
    }

    public function edit($params){
        $article =  $this->articleRepository->findOneBy(['slug'=> $params['slug']]);
        if(!is_null($article)){

            //article :

            $id = $article['id'];
            $author = null;
            $created_at = null;
            $content = $article['content'];
            $slug = $article['slug'];
            $title = $article['title'];
            $image_url = $article['image_url'];
        }
        $this->render('article/edit.html.twig', [
            'article' => $article
        ]);
    }


 
}