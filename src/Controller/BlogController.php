<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormBuilder;
use App\Entity\Article;
use App\Repository\Manager;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()

     {

       $repo= $this->getDoctrine()->getRepository(Article::class);
       $articles= $repo->findAll();
    
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=>$articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){

      $repo= $this->getDoctrine()->getRepository(Article::class);

        return $this->render('blog/home.html.twig');
    }

    /**
         * @Route("/blog/new", name="blog_create")
         * @Route("/blog/{id}/edit", name="blog_edit")
         
         */

        public function form(Article $article=null,Request $request, ObjectManager $manager){
 
            if(!$article){
                $article= new Article();
            }
           // 

            
            //Pour la vue
            //---------------------------------------
            $form= $this->createFormBuilder($article)
            ->add('title')
            ->add('content')
            ->add('image')
           //---------------------------------------
            ->getForm();
           //Analyse de la requête
            $form->handleRequest($request);
        //S i le formulaire est envoyé et que tous les champs sont remplis
           if($form->isSubmitted() && $form->isValid()){
                  if($article->getId()){

                  }
              
             $manager->persist($article);
             
               return $this->redirectToRoute('blog_show',[
                   'id'=> $article->getId()
               ]);
           }
            return $this->render('blog/create.html.twig',[
                'formArticle' => $form->createView()
            ]);
        }

    /**
     * @Route("/blog/show/{id}",name="blog_show")
     */
    public function show($id){

        $repo= $this->getDoctrine()->getRepository(Article::class);

        $article=$repo->find($id);
        return $this->render('blog/show.html.twig',[
           'article'=>$article

        ]);
    }

    
}
