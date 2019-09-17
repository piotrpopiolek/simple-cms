<?php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class ArticleController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index()
    {
        $articles = ['Article 1', 'Article 2', 'Article 3'];

        return $this -> render('articles/index.html.twig', array('articles' => $articles));
    }

    /**
    * @Route("/article/save")
    */
    public function save() {
    
        $entityManager = $this->getDoctrine()->getManager();
    
        $article = new Article();
    
        $article->setTitle('Article Two');
    
        $article->setBody('This is the body for article two');
    
        $entityManager->persist($article);
    
        $entityManager->flush();
    
        return new Response('Saved an article with the id of  '.$article->getId());
    }
}