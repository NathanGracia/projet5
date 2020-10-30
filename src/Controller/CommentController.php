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
        if(!empty($content) && !empty($id_article)){
            $this->commentRepository->insert([
           
                'content' => $content,
                'id_article' => $id_article
            ]);
        }
    
        header('Location: /article/'.$_POST['slug_article']);
    }

   
}