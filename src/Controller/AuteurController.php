<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    #[Route('/auteur_ajout', name: 'app_auteur_ajout')]
    public function ajout(Request $request, ManagerRegistry $doctrine): Response
    {
        $auteur = new Auteur();

        $form = $this->createForm(AuteurType::class, $auteur);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $manager = $doctrine->getManager();
            $manager->persist($auteur);
            $manager->flush();

            return $this->redirectToRoute('articles');
        }


        return $this->render('auteur/formulaire.html.twig', [
            'formAuteur' => $form->createView(),
        ]);
    }


    #[Route('/auteurs', name: 'app_auteurs')]
    public function allAuteurs(ManagerRegistry $doctrine)
    {
        $auteurs = $doctrine->getRepository(Auteur::class)->findAll();

        return $this->render('auteur/auteurs.html.twig' , [
            'auteurs' => $auteurs
        ]);
    }


    #[Route('/auteur_{id<\d+>}', name: 'app_auteur')]
    public function unAuteur($id, ManagerRegistry $doctrine)
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);

        return $this->render('auteur/unAuteur.html.twig', [
            'auteur' => $auteur
        ]);
    }


    #[Route('/auteur_edit_{id<\d+>}', name: 'app_auteur_edit')]
    public function edit($id, ManagerRegistry $doctrine, Request $request)
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);

        $form = $this->createForm(AuteurType::class, $auteur);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
                $manager = $doctrine->getManager();
                $manager->persist($auteur);
                $manager->flush();

                return $this->redirectToRoute('app_auteurs');
        }

        return $this->render('auteur/formulaire.html.twig', [
            'formAuteur' => $form->createView()
        ]);

    }

    #[Route('/auteur_supprimer_{id<\d+>}', name: 'app_auteur_supprimer')]
    public function delete($id, AuteurRepository $repo)
    {
        // on recupére l'auteur dont l'id est dans l'url pour le supprimer
        $auteur = $repo->find($id);
        // on utilise directement la fonction remove() qui se trouve dans AuteurRepository pour la suppression
        $repo->remove($auteur, 1);

        return $this->redirectToRoute("app_auteurs");

    }

}
