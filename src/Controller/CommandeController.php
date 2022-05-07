<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    // #[Route('/commande', name: 'app_commande')]
    // public function index(): Response
    // {
    //     return $this->render('commande/index.html.twig', [
    //         'controller_name' => 'CommandeController',
    //     ]);
    // }

    #[Route('/liste_commande', name: 'liste_commande')]
    public function showCommande(): Response
    {
        return $this->render('commande/liste_commande.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    

    #[Route('/produit', name: 'produit')]
    public function showProduit(): Response
    {
        return $this->render('commande/produit.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    
}
