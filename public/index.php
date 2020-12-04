<?php
ini_set('display_errors', 1);
ini_set('display_errors', 'on');
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Core\Router\Router;

require_once '../vendor/autoload.php';

session_start();
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

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
    die ($controllerName);
}

$controller = new $controllerName();
$actionName = $routeTarget->getActionName();

if (!method_exists($controller, $actionName)) {
    die ('method does not exist');
}

$controller->$actionName($routeTarget->getParameters());
