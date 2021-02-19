<?php


namespace App\Controller;


use App\Model\Entity\User;
use Core\Controller\AController;
use Core\Exception\Http\HttpNotFoundException;
use Core\Model\DB;
use  App\Model\Entity\Article;
use  App\Model\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Core\Form\Constraint\NotEmptyConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Constraint\ValidCsrfConstraint;
use Core\Form\Form;
use Core\Form\Type\TextType;
use Core\Form\Type\CsrfType;
use Ramsey\Uuid;


class ArticleController extends AController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;


    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();

    }


    public function showAction($param)
    {
        $slug = $param["slug"];

        //query select * 
        $result = $this->articleRepository->findOneBy(['slug' => $slug]);
        if (empty($result)) {
            throw new HttpNotFoundException();
        }


        if (!is_null($result)) {

            //article :
            $article = new Article();

            $article->setId($result['id']);
            $article->setIdAuthor($result['id_author']);
            $article->setCreated_at(null);
            $article->setContent($result['content']);
            $article->setSlug($result['slug']);
            $article->setTitle($result['title']);
            $article->setImage_url($result['image_url']);
            $article->setDate($result['date']);
            $article->setchapo($result['chapo']);


            //query select *
            $authorResult = $this->userRepository->findOneBy(['id' => $article->getIdAuthor()]);

            if (empty($result)) {
                $author = null;
            } else {
                $author = new User();
                $author->setId($authorResult['id']);
                $author->setName($authorResult['name']);
                $author->setEmail($authorResult['email']);
            }

            //commentaires :
            $comments = [];
            $bddComments = $this->commentRepository->findBy(['id_article' => $result['id'], 'approved' => '1']);
            foreach ($bddComments as $bddComment) {

                $comment = new Comment();

                $comment->setId($bddComment['id']);
                $comment->setId_author($bddComment['id_author']);
                $comment->setContent($bddComment['content']);
                $comment->setCreated_at($bddComment['created_at']);
                $comment->setId_article($bddComment['id_article']);

                array_push($comments, $comment);
            }


            $this->displayRender('article/show.html.twig', [
                "article" => $article,
                "author" => $author,
                "comments" => $comments
            ]);
        } else {
            $this->displayRender('404.html.twig');
        }


    }

    public function indexAction()
    {


        $articles = $this->articleRepository->findAll();
        $this->displayRender('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    public function new()
    {
        $this->displayRender('article/new.html.twig');
    }

    public function create()
    {

        if(empty($_SESSION['user'])){
            $this->redirectTo('/connexion');
        }

        $article = new Article();

        $form = new Form([
            'title' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'chapo' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            'image_url' => new TextType(),
            'content' => new TextType([
                new NotNullConstraint(),
                new NotEmptyConstraint()
            ]),
            '_csrf' => new CsrfType([
                new ValidCsrfConstraint()
            ])
        ], $article);

        $form->handleRequest();

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = strtolower(str_replace(" ", "-", $article->getTitle()));
            $article->setSlug($slug);

            $date = $timestamp = date('Y-m-d H:i:s');
            $article->setDate($date);

            $idAuthor = $_SESSION['user']['id'];
            $article->setIdAuthor($idAuthor);


            //envoie en bdd
            $this->articleRepository->insert([

                'content' => $article->getContent(),
                'image_url' => $article->getImage_url(),
                'title' => $article->getTitle(),
                'slug' => $article->getSlug(),
                'date' => $article->getDate(),
                'chapo' => $article->getChapo(),
                'id_author' => $article->getIdAuthor()

            ]);
            $this->redirectTo('/article/' . $slug);

        }
        $this->displayRender('article/new.html.twig', [
            'form' => $form
        ]);
    }

    public function edit($params)
    {
        $article = $this->articleRepository->findOneBy(['slug' => $params['slug']]);
        if (!is_null($article)) {


            $form = new Form([
                'title' => new TextType([
                    new NotNullConstraint(),
                    new NotEmptyConstraint()
                ]),
                'chapo' => new TextType([
                    new NotNullConstraint(),
                    new NotEmptyConstraint()
                ]),
                'image_url' => new TextType(),
                'content' => new TextType([
                    new NotNullConstraint(),
                    new NotEmptyConstraint()
                ]),
                '_csrf' => new CsrfType([
                    new ValidCsrfConstraint()
                ])
            ], $article);


            $form->handleRequest();


            if ($form->isSubmitted() && $form->isValid()) {


                $article->setDate(new \DateTime());

                $idAuthor = $_SESSION['user']['id'];
                $article->setIdAuthor($idAuthor);


                //envoie en bdd
                $this->articleRepository->update(['slug'=>$params['slug']],[

                    'content' => $article->getContent(),
                    'image_url' => $article->getImage_url(),
                    'title' => $article->getTitle(),
                    'date' => $article->getDate(),
                    'chapo' => $article->getChapo(),
                    'id_author' => $article->getIdAuthor()

                ]);
                $this->redirectTo('/article/' . $article['slug']);
            }
            $this->displayRender('article/edit.html.twig', [
                'form' => $form,
                'article' => $article
            ]);
        }
    }

    public function delete($params)
    {

        if (empty($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
            die('419'); //todo exception perm
        }

        $this->articleRepository->deleteBy(['id' => $params['id']]);


        $this->redirectTo('/articles');


    }


}