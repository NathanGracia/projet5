<?php


namespace App\Controller;


use Core\Controller\AController;
use Core\Model\DB;
use  App\Model\Entity\Comment;
use App\Repository\CommentRepository;


class CommentController extends AController
{
   /**
     * @var CommentRepository
     */
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    public function create(){
      
    }

   
}