<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 11; $i++) { 
        $article = new Article();

        $article->setTitre("mon titre $i")
                ->setContenu("Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, maxime neque nulla debitis inventore vero, architecto adipisci autem officia unde labore eveniet temporibus delectus, vitae deserunt iste non. Dolores, a.")
                ->setDateDeCreation(new DateTime("now"));

                $manager->persist($article);
            

        }

        $manager->flush();
    }
}
