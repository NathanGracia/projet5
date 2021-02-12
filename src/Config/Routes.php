<?php

namespace App\Config;

use App\Controller\ArticleController;
use App\Controller\CommentController;
use App\Controller\ContactController;
use App\Controller\UserController;
use Core\Router\IRoutes;
use Core\Router\Route;

abstract class Routes implements IRoutes
{
    public static function getRoutes(): array
    {
        return [
            new Route('/article', ArticleController::class, 'showAction'),
            new Route('/article/nouveau', ArticleController::class, 'create'),
            new Route('/article/edit/{slug}', ArticleController::class, 'edit'),
            new Route('/article/delete/{id}', ArticleController::class, 'delete'),
            new Route('/article/{slug}', ArticleController::class, 'showAction'),
            new Route('/articles', ArticleController::class, 'indexAction'),
            new Route('/connection', UserController::class, 'login'),
            new Route('/inscription', UserController::class, 'signin'),
            new Route('/administration/commentaires', CommentController::class, 'indexAction'),
            new Route('/comment/approve/{id}', CommentController::class, 'approve'),
            new Route('/comment/delete/{id}', CommentController::class, 'delete'),

            new Route('/comment/create', CommentController::class, 'createComment'),
            new Route('/contact', ContactController::class, 'contactForm'),

            new Route('/utilisateurs', UserController::class, 'index'),
            new Route('/utilisateur/nouveau', UserController::class, 'create'),
            new Route('/utilisateur/supprimer/{id}', UserController::class, 'delete'),
            new Route('/utilisateur/{id}', UserController::class, 'show'),
            new Route('/profil', UserController::class, 'profil'),

        ];
    }
}