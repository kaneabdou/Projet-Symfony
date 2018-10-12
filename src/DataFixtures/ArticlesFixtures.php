<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <10 ; $i++) { 
      	
      	     $article= new Article();
      	     $article->setTitle("Titre de l'article n° $i ")
      	             ->setContent("<p>Contenue de l'article n° $i </p>")
      	             ->setImage("http://placehold.it/350x150")
      	             ->setCreatedAt(new \DateTime());

      	     $manager->persist($article);
        }
        

        $manager->flush();
    }
}
