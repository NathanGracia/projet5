<?php

require_once '../vendor/autoload.php';

use App\Config\Config;
use Core\Exception\Http\HttpInternalErrorException;
use Core\Router\Router;
use Core\Exception\Http\AHttpException;
use Core\Exception\Http\HttpNotFoundException;
use Core\Controller\ExceptionController;
use Symfony\Component\VarDumper\VarDumper;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

session_start();
if(Config::DEBUG){
    if(!class_exists(Run::class)){
        die('Faites un composer update avec les dépendances devs');
    }
    $whoops = new Run;
    $whoops->pushHandler(new PrettyPageHandler);
    $whoops->register();
}else{
    if(class_exists(VarDumper::class)){

        VarDumper::setHandler(function($var) {});
    }
    if(!function_exists('dump')){
        function dump(){
        }
    }
    if(!function_exists('dd')){
        function dd(){
        }
    }
}


$url = $_SERVER['PATH_INFO'] ?? 'default/index';

//enlève le / a la fin de l'url si il y'en a un
if ($url[strlen($url) - 1] === '/') {
    $url = substr($url, 0, -1);
}

try {

    $router = new Router();
    $routeTarget = $router->findRoute($url);


    if(!$routeTarget){
        throw new HttpNotFoundException();
    }

    $controllerName = $routeTarget->getControllerClass();

    if (!class_exists($controllerName)) {
        throw new HttpNotFoundException();
    }

    $controller = new $controllerName();
    $actionName = $routeTarget->getActionName();

    if (!method_exists($controller, $actionName)) {
        throw new HttpNotFoundException();
    } 

    $controller->$actionName($routeTarget->getParameters());
 } catch (AHttpException $e) {
    if(!Config::DEBUG){
        (new ExceptionController)->errorAction($e);
    }
    else{
        $whoops->handleException($e);
    }

} catch (Exception $e) {
    if(!Config::DEBUG){
        (new ExceptionController)->errorAction(new HttpInternalErrorException());
    }else{
        $whoops->handleException($e);
    }


}
