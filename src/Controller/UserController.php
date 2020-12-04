<?php


namespace App\Controller;


use Core\Controller\AController;
use App\Model\Entity\User;
use Core\Form\Form;
use Core\Form\Type\TextType;
use App\Repository\UserRepository;
use Core\Form\Constraint\NotEmptyConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Type\CsrfType;
use Core\Form\Constraint\ValidCsrfConstraint;

class UserController extends AController
{

        /**
     * @var UserRepository
     */
    private  $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }


    public function login()
    {
  
        $user =  new User();

        $form = new Form([
            'email' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'password' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            '_csrf' => new CsrfType([
                new ValidCsrfConstraint()
            ])
            ],$user);

            $form->handleRequest();
           
       
            if ($form->isSubmitted() && $form->isValid()) {
           
                $userFromBDD =  $this->userRepository->findOneBy(['email'=>$user->getEmail()]);
               
                
                if(password_verify($user->getPassword(),$userFromBDD['password'])){
                    $_SESSION['user'] = $userFromBDD;

                    header('Location: /utilisateurs/'.$userFromBDD['id']); 
                }else{
                    dump(password_hash('1234', PASSWORD_BCRYPT));
                    dd($userFromBDD['password']);
                }

            }
            $this->render('user/login.html.twig',[
                'form' => $form
                ]);
       
        
        
        
    }
     public function signin()
    {
      
        
        $user =  new User();

        $form = new Form([
            'email' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'name' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'password' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            '_csrf' => new CsrfType([
                new ValidCsrfConstraint()
            ])
            ],$user);

            $form->handleRequest();
           
            if ($form->isSubmitted() && $form->isValid()) {
       
                //hashage

                $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT)) ;
                //checker si l'user existe déjà

                
                //envoie en bdd
                $this->userRepository->insert([
           
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'password' => $user->getPassword()
                   
    
                ]);
                    dd('utilisateur enregistré');
                //redirect
            }


            $this->render('user/signin.html.twig', [
                'form' => $form
            ]);
       
        
        
        
    }

    public function show($id){
        $user =  $this->userRepository->findOneBy(['id'=>$id]);
        echo('<h1> Page de l\'utilisateur </h1>');
        dump($user);
    }
}