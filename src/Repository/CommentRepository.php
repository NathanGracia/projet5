<?php


namespace App\Repository;


use App\Entity\Comment;
use Core\Repository\ARepository;

class CommentRepository extends ARepository
{
    protected function getEntity(): string
    {
        return Comment::class;
    }
}