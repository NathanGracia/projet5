<?php

require_once '../vendor/autoload.php';


$uri = $_GET['uri'] ?? 'default.index';
$param = $_GET['param'] ?? '';
$uriParts = explode('.', $uri);

$controllerName = 'App\\Controller\\' . ucfirst($uriParts[0]) . 'Controller';

if (!class_exists($controllerName)) {
    die ('404');
}

$controller = new $controllerName();
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

