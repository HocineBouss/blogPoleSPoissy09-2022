<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'app_articles')]
    public function articles(ManagerRegistry $doctrine): Response
    {
        // on récupere les articles
        $articles = $doctrine->getRepository(Article::class)->findAll();

        // on verifie si on a bien tous les articles
        //dd($articles);
        
        return $this->render('article/articles.html.twig', [
            'articles' => $articles
        ]);
    }

   
    #[Route('/article_{id<\d+>}', name: 'app_article')]
    public function unArticle(ManagerRegistry $doctrine, $id)
    {
        // on récuper l'article dont l'id est celui dans l'url
        $article = $doctrine->getRepository(Article::class)->find($id);

        //on verifie si je recupere bien un article
        //dd($article);

        return $this->render('article/unArticle.html.twig', [
            'article' => $article
        ]);

    }   


    #[Route('/article_ajout', name: 'app_article_ajout')]
    public function ajout(Request $request, ManagerRegistry $doctrine)
    {
        // on crée un objet Article
        $article = new Article(); // une instanciation de class

        // on lie ArticleType avec l'objet crée
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            // on affecte la date car elle ne s'ajoute pas depuis le formulaire
            $article->setDateDeCreation(new DateTime("now"));
            
            // on recupere le manager de doctrine
            $manager = $doctrine->getManager();

            $manager->persist($article);

            $manager->flush();

            return $this->redirectToRoute('app_articles');
        }
    
        return $this->render('article/formulaire.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }



    #[Route('/article_editer/{id<\d+>}', name: 'app_article_editer')]
    public function edit(ManagerRegistry $doctrine, $id, Request $request)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);

        // on lie ArticleType avec l'objet crée
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            // on affecte la date car elle ne s'ajoute pas depuis le formulaire
            $article->setDateDeModification(new DateTime("now"));
            
            // on recupere le manager de doctrine
            $manager = $doctrine->getManager();

            $manager->persist($article);

            $manager->flush();

            return $this->redirectToRoute('app_articles');
        }
    
        return $this->render('article/formulaire.html.twig', [
            'formArticle' => $form->createView()
        ]);

    }


    #[Route('/article_supprimer/{id<\d+>}', name: 'app_article_supprimer')]
    public function delete(ManagerRegistry $doctrine, $id)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('app_articles');
    }

    
}
