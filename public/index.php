<?php

require_once '../vendor/autoload.php';


//recup le parametre uri : public?uri=article.show
$uri = $_GET['uri'] ?? 'default.index'; 
$param = $_GET['param'] ?? '';
$uriParts = explode('.', $uri);

//trouve le controller
$controllerName = 'App\\Controller\\' . ucfirst($uriParts[0]) . 'Controller';

if (!class_exists($controllerName)) {
    die ('404');
}
$controller = new $controllerName();

//trouve la methode
$actionName = ucfirst($uriParts[1]) . 'Action';

if (!method_exists($controller, $actionName)) {
    die ('404.2');
}


if(!empty($param)) {
    $controller->$actionName($param);
}
else {
    $controller->$actionName();
}

