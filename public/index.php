<?php

use Core\Router\Router;

require_once '../vendor/autoload.php';

$url = $_SERVER['PATH_INFO'] ?? 'default/index';

//enlève le / a la fin de l'url si il y'ne a un
if ($url[strlen($url) - 1] === '/') {
    $url = substr($url, 0, -1);
}

$router = new Router();
$routeTarget = $router->findRoute($url);


if (!$routeTarget) {
    die ('404');
}

$controllerName = $routeTarget->getControllerClass();

if (!class_exists($controllerName)) {
    die ('500');
}

$controller = new $controllerName();
$actionName = $routeTarget->getActionName();

if (!method_exists($controller, $actionName)) {
    die ('500');
}

$controller->$actionName($routeTarget->getParameters());
