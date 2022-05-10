<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted("ROLE_GESTIONNAIRE")
 */
class GestionnaireController extends AbstractController
{
    #[Route('/gestionnaire', name: 'app_gestionnaire')]
    public function index(): Response
    {
        return $this->render('gestionnaire/index.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }

    #[Route('/liste_commandes_client', name: 'client_gestionnaire')]
    public function showCommandeClient(): Response
    {
        return $this->render('gestionnaire/liste_commandes_client.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }

    #[Route('/ajout_produit', name: 'ajout_produit')]
    public function addProduit(): Response
    {
        return $this->render('gestionnaire/ajout_produit.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }

    #[Route('/tableau_bord', name: 'tableau_bord')]
    public function showSatistique(): Response
    {
        return $this->render('gestionnaire/tableau_bord.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }


    

}
