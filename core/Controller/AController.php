<?php

namespace Core\Controller;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class AController
{
    /**
     * Render the view
     *
     * @param string $name The template name
     * @param array $context The context
     *
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    protected function render(string $name, array $context = [])
    {
        $loader = new FilesystemLoader('../template');
        $twig = new Environment($loader, [
//            'cache' => '../var/cache'
        ]);
        $twig->addFunction(
            new TwigFunction('dump', function(...$vars){
               foreach( $vars as $var){
                   dump($var);
               }
            } )
        );
        $twig->addFunction(
            new TwigFunction('user', function(){
               if(isset($_SESSION['user'])){
                return $_SESSION['user'];
               }else{
                   return null;
               }
                
            } )
        );
        $twig->addFunction(
            new TwigFunction('isAdmin', function($user){
             return true;
                
            } )
        );
        echo $twig->render($name, $context);
    }
}