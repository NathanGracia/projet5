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
use Ramsey\Uuid\Uuid;

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
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'){
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

        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin') {
            $user = new User();

            $form = new Form([
                'email' => new TextType([
                    new NotNullConstraint(),
                    new NotEmptyConstraint()
                ]),
                '_csrf' => new CsrfType([
                    new ValidCsrfConstraint()
                ])
            ], $user);

            $form->handleRequest();

            if ($form->isSubmitted() && $form->isValid()) {
                //envoie en bdd
                $token = Uuid::uuid4()->toString();
                $this->userRepository->insert([

                    'email' => $user->getEmail(),
                    'token' => $token
                ]);
                // Create the Transport
                $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
                    ->setUsername('nathan.gracia.863@gmail.com')
                    ->setPassword('unqdljjregvmadvf');

                // Create the Mailer using your created Transport
                $mailer = new \Swift_Mailer($transport);

                // Create a message
                $message = (new \Swift_Message('Activez votre compte'))
                    ->setFrom('nathan.gracia.863@gmail.com')
                    ->setReplyTo('nathan.gracia.863@gmail.com')
                    ->setTo($user->getEmail())
                    //->setBody($this->render('mail/signin.html.twig', ['token' => $token]));
                    ->setBody('<a href="http://localhost:8000/utilisateur/validerCompte/'.$token.' style="color: #ffffff; text-decoration: none; padding: 1%">VALIDER MON COMPTE</a>
                       ');

                // Send the message
                $result = $mailer->send($message);
                $this->redirectTo('/utilisateurs');
            }


            $this->render('user/create.html.twig', [
                'form' => $form
            ]);
        }




    }
    public function test(){
        $this->render('mail/signin.html.twig');
    }

    public function validateAccount($param){
        $token = $param['token'];

        //check si un utilisateur existe
        $oldUser = $this->userRepository->findOneBy(['token' => $token]);
        if(!empty($oldUser)){
            $time = strtotime($oldUser['token_date']);
            $secondsIn7days = 60*60*24*7;
            $actualTime = time();
            //check si ça fait moins de 7 jours que le token a été créé
            if($actualTime-$secondsIn7days < $time){

                $user = new User();
                $form = new Form([
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
                ], $user);
                $form->handleRequest();

                if ($form->isSubmitted() && $form->isValid()) {


                    $this->userRepository->update(['id'=>$oldUser['id']], ['password' => password_hash($user->getPassword(), PASSWORD_DEFAULT), 'name'=> $user->getName(), 'activated'=> '1']);
                    $_SESSION['user'] = $this->userRepository->findOneBy(['id'=> $oldUser['id']]);
                    $this->redirectTo('/utilisateur/'.$oldUser['id']);
                }


                $this->render('user/finishAccount.html.twig', [
                    'form' => $form,
                    'token' => $param['token']
                ]);
            }
        }

    }

    public function unconnect(){
        $_SESSION['user'] = null;
        $this->redirectTo('/articles');
    }


}