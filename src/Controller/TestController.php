<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{

    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {

        $personnes = [

             [ 
                'nom' => 'Awel', 
                'prenom' => 'Yadaf'
             ],

            [
                 'nom' => 'Danciu',
                  'prenom' => "Delia" 
            ],

            [ 
                'nom' => 'Gimbert', 
                'prenom' => "Dominique"
            ]
        ];

        $prenom = "Hocine";
        $nom = "Boussaid";

        return $this->render('test.html.twig', [
            'prenom' => $prenom,
            'nom' => $nom,
            'personnes' => $personnes
        ] );
    }
}
