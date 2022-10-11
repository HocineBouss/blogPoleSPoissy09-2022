<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire_update_{id<\d+>}', name: 'app_commentaire_update')]
    public function update(ManagerRegistry $doctrine, $id, Request $request): Response
    {
        // on recupere le commentaire a modifier dont l'id est en parametre de la route
        $commentaire = $doctrine->getRepository(Commentaire::class)->find($id);
        // on recupere l'article lié au commentaire recuperé précedement
        $article = $commentaire->getArticle();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            $manager = $doctrine->getManager();
            $manager->persist($commentaire);
            $manager->flush();

            return $this->redirectToRoute('app_article', ['id' => $article->getId() ]);
        }

        return $this->render('article/unArticle.html.twig', [
            'formCommentaire' => $form->createView(),
            'article' => $article,
            'commentaires' => $article->getCommentaires()
        ]);
    }

    #[Route('/commentaire_supprimer_{id<\d+>}', name: 'app_commentaire_supprimer')]
    public function delete(CommentaireRepository $repo, $id)
    {
        $commentaire = $repo->find($id);
        $article = $commentaire->getArticle();

        $repo->remove($commentaire, 1);

        return $this->redirectToRoute('app_article', ['id' => $article->getId()]);
    }   
}
