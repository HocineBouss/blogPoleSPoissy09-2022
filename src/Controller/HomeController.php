<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
   // la route de cette fonction se trouve dans config/route.yaml
    public function index(ManagerRegistry $doctrine): Response
    {
        // on recupére le dernier article en bdd (obselete en version 6 de symfony)
        // $dernierArticle = $this->getDoctrine()->getRepository(Article::class)->findOneBy([],["dateDeCreation" => "DESC"]);
        // depuis le version 6 de symfony
        $dernierArticle = $doctrine->getRepository(Article::class)->findOneBy([],["dateDeCreation" => "DESC"]);
        // on verifie le contenu de notre variable
        // dd($dernierArticle);

        
        return $this->render('home/index.html.twig', [
            'article' => $dernierArticle
        ]);
    }
}
