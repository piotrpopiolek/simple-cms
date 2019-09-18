<?php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ArticleController extends Controller
{
    
    /**
     * @Route("/", name="list_articles")
     * @Method({"GET"})
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this -> render('articles/index.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/article/new", name="new_article")
     * Method({"GET","POST"})
     */
    public function new(Request $request){
        $article = new Article();
        $form = $this->createFormBuilder($article)
        ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('body', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute("list_articles");
        }

        return $this->render('articles/new.html.twig', array('form' => $form->createView()));
    }

    /**
    * @Route("/article/{id}", name="show_article")
    */
    public function show($id){
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        

        return $this->render('articles/show.html.twig', array('article' => $article));
    }
}