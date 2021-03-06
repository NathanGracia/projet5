<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Core\Controller\AController;
use Core\Model\DB;
use  App\Model\Entity\Comment;
use Core\Form\Form;
use App\Repository\CommentRepository;


class CommentController extends AController
{
   /**
     * @var CommentRepository
     */
    private CommentRepository $commentRepository;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var ArticleRepository
     */
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
        $this->articleRepository = new ArticleRepository();
    }


    public function createComment(){
        if(empty($_SESSION['user'])) {
            $id_author= 0;
        }else{
            $id_author = htmlspecialchars($_SESSION['user']['id']);
        }
        $content = htmlspecialchars( $_POST['content']);
        $id_article = htmlspecialchars($_POST['id_article']);

        $created_at = $timestamp = date('Y-m-d H:i:s');

        if(!empty($content) && !empty($id_article)){
            $this->commentRepository->insert([
           
                'content' => $content,
                'id_article' => $id_article,
                'id_author' => $id_author,
                'created_at' => $created_at
            ]);

        }


        $this->redirectTo('/article/'.$_POST['slug_article']);
    }
    public function indexAction(){


        $comments =  $this->commentRepository->findBy(['approved' => '0']);
        foreach ($comments as $key => $comment){
            $comments[$key]['author'] = $this->userRepository->findOneBy(['id' => $comment['id_author']]);
            $comments[$key]['article'] = $this->articleRepository->findOneBy(['id' => $comment['id_article']]);

        }

        $this->displayRender('admin/commentList.html.twig',[
            'comments' =>$comments
        ]);
    }

    public function delete($parameters){
        if(empty($_SESSION["user"] ) || $_SESSION["user"]["role"] != "admin" ){
            $this->redirectTo('/accueil');
        }


        $this->commentRepository->deleteBy(['id' => $parameters['id']]);



        $this->redirectTo('/administration/commentaires');
    }
    public function approve($parameters){
        if(empty($_SESSION["user"] ) || $_SESSION["user"]["role"] != "admin" ){
            $this->redirectTo('/accueil');
        }

        $this->commentRepository->update(['id' => $parameters['id']], ['approved'=> 1]);



        $this->redirectTo('/administration/commentaires');
    }

   
}