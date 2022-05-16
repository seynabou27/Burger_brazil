<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use App\Repository\MenusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/Liste_burgers', name: 'liste_burgers')]
    public function showBurgers(BurgerRepository $repoburger): Response
    {

         //liste burger
         $burger = $repoburger -> findAll();

        return $this->render('gestionnaire/Liste_burgers.html.twig', [
            'burger' => $burger
        ]);
    }

    #[Route('/Liste.menus', name: 'liste_menus')]
    public function showMenus(MenusRepository $repoMenu): Response
    {

       

        //liste menu
        $menus = $repoMenu -> findAll();
        return $this->render('gestionnaire/Liste.menus.html.twig', [
            
            'menus'=> $menus
        ]);
    }

    #[Route('/Liste_complement', name: 'liste_complement')]
    public function showComplemnt( ComplementRepository $repoComplet): Response
    {

        
        
        //liste complement
        $complement = $repoComplet ->findAll();
        return $this->render('gestionnaire/Liste_complement.html.twig', [
            'complement'=> $complement
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
        if($this->getUser()){
            $role = $this->getUser()->getRoles()[0];
        }else{
            $role = "";
        }
        return $this->render('gestionnaire/tableau_bord.html.twig', [
            'role' => $role,
        ]);
    }

    #[Route('/produit', name: 'produit')]
    public function showProduit(Request $request,
                                BurgerRepository $repoburger,
                                ComplementRepository $repoComplet,
                                MenusRepository $repoMenu): Response

    {
        if($this->getUser()){
            $role = $this->getUser()->getRoles()[0];
        }else{
            $role = "";
        }
        //liste burger
        $burger = $repoburger -> findAll();

        //liste menu
        $menus = $repoMenu -> findAll();
        
        //liste complement
        $complement = $repoComplet ->findAll();

        return $this->render('gestionnaire/produit.html.twig', [
            'role' =>  $role,
            'burger' => $burger,
            'menus'=> $menus,
            'complement'=> $complement,

        ]);
    }
    // #[Route('/produit', name: 'add_produit')]
    // public function addMenu( Request $request,
    //                         BurgerRepository $repoburger){

            

    // }
    


    

}
