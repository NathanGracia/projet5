<?php


namespace App\Controller;


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
    private  $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }


    public function createComment(){
        $content = htmlspecialchars( $_POST['content']);
        $id_article = htmlspecialchars($_POST['id_article']);
        $id_author = htmlspecialchars($_POST['id_author']);
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

   
}