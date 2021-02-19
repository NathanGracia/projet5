<?php 
namespace Core\Controller;

use Core\Exception\Http\AHttpException;
use Core\Exception\Http\HttpNotFoundException;

class ExceptionController extends AController{

    public function errorAction(AHttpException $e){
        http_response_code($e->getHttpCode());
        if($e instanceof HttpNotFoundException){
            $this->displayRender('exception/404.html.twig', ['exception' => $e]);
        }else{
            $this->displayRender('exception/error.html.twig', ['exception' => $e]);
        }

    }

}