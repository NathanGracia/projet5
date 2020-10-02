<?php


namespace App\Repository;


use App\Entity\Article;
use Core\Repository\ARepository;

class ArticleRepository extends ARepository
{
    protected function getEntity(): string
    {
        return Article::class;
    }
}