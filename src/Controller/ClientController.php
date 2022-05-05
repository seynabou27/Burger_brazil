<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/catalogue', name: 'catalogue')]
    public function catalogue(): Response
    {
        return $this->render('client/catalogue.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/details', name: 'details')]
    public function details(): Response
    {
        return $this->render('client/details.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
