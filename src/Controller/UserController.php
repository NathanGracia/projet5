<?php


namespace App\Controller;


use Core\Controller\AController;
use App\Model\Entity\User;
use Core\Form\Form;
use Core\Form\Type\TextType;
use App\Repository\UserRepository;
use Core\Form\Constraint\NotEmptyConstraint;
use App\Repository\CommentRepository;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Type\CsrfType;
use Core\Form\Constraint\ValidCsrfConstraint;

class UserController extends AController
{

        /**
     * @var UserRepository
     */
    private  $userRepository;

          /**
     * @var CommentRepository
     */
    private  $commentRepository;


    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
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

                if($userFromBDD['activated'] == 0){
                    dd('mauvais ids');
                }
                
                if(password_verify($user->getPassword(),$userFromBDD['password'])){
                    $_SESSION['user'] = $userFromBDD;

                    $this->redirectTo('/profil');
                }else{
                    dd('mauvais ids');
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

    public function profil(){
        $user =  $_SESSION['user'];
        $commments = $this->commentRepository->findBy(['id_author'=> $user['id']]); 
    
        $this->render('user/show.html.twig', [
            'user' => $user,
            'comments' => $commments
        ]);
    }
    public function show($params){
        $user =  $this->userRepository->findOneBy(['id'=>$params['id']]);
        $commments = $this->commentRepository->findBy(['id_author'=> $params['id']]);

        $this->render('user/show.html.twig', [
            'user' => $user,
            'comments' => $commments
        ]);
    }
    public function index(){
        if($_SESSION['user']['role'] == 'admin'){
            $users =  $this->userRepository->findAll();
            $this->render('user/index.html.twig',[
                'users' =>$users
            ]);
        }

    }
    public function delete($params){

        if(empty($_SESSION["user"] ) || $_SESSION["user"]["role"] != "admin" ){
            die('419'); //todo exception perm
        }

        $this->userRepository->deleteBy(['id' => $params['id']]);



        $this->redirectTo('/utilisateurs');


    }
    public function create()
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
            '_csrf' => new CsrfType([
                new ValidCsrfConstraint()
            ])
        ],$user);

        $form->handleRequest();

        if ($form->isSubmitted() && $form->isValid()) {
            //envoie en bdd
            $this->userRepository->insert([

                'email' => $user->getEmail(),
                'name' => $user->getName()


            ]);
            // Create the Transport
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
                ->setUsername('nathan.gracia.863@gmail.com')
                ->setPassword('unqdljjregvmadvf')
            ;

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message('Activez votre compte'))
                ->setFrom('nathan.gracia.863@gmail.com')
                ->setReplyTo('nathan.gracia.863@gmail.com')
                ->setTo($user->getEmail())
                ->setBody('test')
            ;

            // Send the message
            $result = $mailer->send($message);
            $this->redirectTo('/utilisateurs');
        }


        $this->render('user/create.html.twig', [
            'form' => $form
        ]);




    }


}