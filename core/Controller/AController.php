<?php

namespace Core\Controller;

use App\Model\Entity\User;
use App\Repository\UserRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class AController
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @param string $name
     * @param array $context
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $name, array $context): string
    {
        $loader = new FilesystemLoader('../template');
        $twig = new Environment($loader, [
//            'cache' => '../var/cache'
        ]);
        $twig->addFunction(
            new TwigFunction('dump', function (...$vars) {
                foreach ($vars as $var) {
                    dump($var);
                }
            })
        );
        $twig->addFunction(
            new TwigFunction('user', function () {
                if (isset($_SESSION['user'])) {
                    $userResult = $this->getUserRepository()->findOneBy(['id' => $_SESSION['user']['id']]);
                    $user = new User();

                    $user->setId($userResult['id']);
                    $user->setRole($userResult['role']);
                    $user->setEmail($userResult['email']);
                    $user->setName($userResult['name']);


                    return $user;
                } else {
                    return null;
                }

            })
        );
        $twig->addFunction(
            new TwigFunction('isAdmin', function ($user) {
                if (!empty($user)) {
                    return $user->isAdmin();
                    true;
                } else {
                    return false;
                }


            })
        );

        $render = $twig->render($name, $context);
        return $render;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        if(!isset($this->userRepository)){
            $this->setUserRepository(new UserRepository());
        }
        return $this->userRepository;
    }

    /**
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }
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
    protected function displayRender(string $name, array $context = [])
    {
        echo $this->render($name, $context);
    }
    public function redirectTo($url){
        header('Location: '.$url);
        die();

    }
}