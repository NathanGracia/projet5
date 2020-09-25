<?php

namespace App\Config;

use App\Controller\ArticleController;
use Core\Router\IRoutes;
use Core\Router\Route;

abstract class Routes implements IRoutes
{
    public static function getRoutes(): array
    {
        return [
            new Route('/article', ArticleController::class, 'showAction'),
            new Route('/article/{slug}', ArticleController::class, 'showAction'),
            new Route('/articles', ArticleController::class, 'indexAction'),
        ];
    }
}