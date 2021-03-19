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
        $errors = [];
       
            if ($form->isSubmitted() && $form->isValid()) {
           
                $userFromBDD =  $this->userRepository->findOneBy(['email'=>$user->getEmail()]);

                if($userFromBDD['activated'] == 0){
                    $errors[] = "Ce compte n'est pas encore actif";
                }
                
                if(password_verify($user->getPassword(),$userFromBDD['password'])){
                    $_SESSION['user'] = $userFromBDD;

                    $this->redirectTo('/profil');
                }else{
                    $errors[] = "Mauvais identifiants ou mauvais mot de passe";
                }

            }
            $this->displayRender('user/login.html.twig',[
                'form' => $form,
                'errors' => $errors
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
                $this->redirectTo('/utilisateurs');
            }


            $this->displayRender('user/signin.html.twig', [
                'form' => $form
            ]);
       
        
        
        
    }

    public function profil(){
        $user =  $_SESSION['user'];
        $commments = $this->commentRepository->findBy(['id_author'=> $user['id']]); 
    
        $this->displayRender('user/show.html.twig', [
            'user' => $user,
            'comments' => $commments
        ]);
    }
    public function show($params){
        $user =  $this->userRepository->findOneBy(['id'=>$params['id']]);
        $commments = $this->commentRepository->findBy(['id_author'=> $params['id']]);

        $this->displayRender('user/show.html.twig', [
            'user' => $user,
            'comments' => $commments
        ]);
    }
    public function index(){

        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'){
            $users =  $this->userRepository->findAll();
            $this->displayRender('user/index.html.twig',[
                'users' =>$users
            ]);
        }

    }
    public function delete($params){

        if(empty($_SESSION["user"] ) || $_SESSION["user"]["role"] != "admin" ){
            $this->redirectTo('/accueil');
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
                    ->setBody($this->render('mail/signin.html.twig', ['token' => $token]),  'text/html');


                // Send the message
                $result = $mailer->send($message);
                $this->redirectTo('/utilisateurs');
            }


            $this->displayRender('user/create.html.twig', [
                'form' => $form
            ]);
        }




    }
    public function test(){
        $this->displayRender('mail/signin.html.twig');
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


                $this->displayRender('user/finishAccount.html.twig', [
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

    public function toAdmin($params){
        $idUser = $params['id'];
        if(!empty($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'){
            $this->userRepository->update(['id'=>$idUser], ['role' => 'admin']);
            $this->redirectTo('/utilisateurs');
        }
    }


}