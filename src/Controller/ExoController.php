<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExoController extends AbstractController
{
    #[Route('/mon-exo', name: 'app_exo')]
    public function index(): Response
    {
        return $this->render('exo/index.html.twig');
    }
}
