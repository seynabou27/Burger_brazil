<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted("ROLE_GESTIONNAIRE")
 */
class CommandeController extends AbstractController
{
    // #[Route('/commande', name: 'app_commande')]
    // public function index(): Response
    // {
    //     return $this->render('commande/index.html.twig', [
    //         'controller_name' => 'CommandeController',
    //     ]);
    // }
    private const LIMIT=3;
    #[Route('/liste_commande', name: 'liste_commande')]
    public function showCommande(CommandeRepository $repoCommande,
                                 UserRepository $repoUser,
                                 SessionInterface $session,
                                 Request $request): Response
    {
        $commandes = $repoCommande -> findAll();
        //Recuperation du Parametre Get et Initiamisation à 1
        $page=(int)$request->query->get("page",1) ;
        //Recuperation du nbre Element
        // $count=(int)$repoCommande->countCommandes($commandes);
        // $commander=$repoCommande->findPaginate($page,$limit,$commandes);
 

        return $this->render('commande/liste_commande.html.twig', [
                'commandes' =>$commandes,
                // 'commander' => $commander ,
            //    'count' =>  $count,
               'limit' =>  self::LIMIT,
               'page' =>   $page,
        ]);
    }


    // #[Route('/produit', name: 'produit')]
    // public function showProduit(): Response
    // {
    //     return $this->render('commande/produit.html.twig', [
    //         'controller_name' => 'CommandeController',
    //     ]);
    // }

    
}
