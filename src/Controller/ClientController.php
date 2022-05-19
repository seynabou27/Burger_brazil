<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\MenusRepository;
use App\Repository\BurgerRepository;
use App\Repository\CommandeRepository;
use App\Repository\ComplementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/', name: 'catalogue')]
    public function catalogue(BurgerRepository $repoBurger,
                            MenusRepository $repoMenu,
                            ComplementRepository $repoComplet,
                            Request $request): Response
    {
        if($this->getUser()){
            $role = $this->getUser()->getRoles()[0];
        }else{
            $role = "";
        }
            
            // dd($complements);
         
            $burgers = $repoBurger -> findBy(['etat'=>'non_archiver']);
            $menus = $repoMenu -> findBy(['etat'=>'non_archiver']);
            $catalogue = array_merge($menus,$burgers);
    
            // foreach ($catalogue as $value) {
            //     if($value->getId()==$id){
            //         if($value->getType() == "menu"){
            //             $catalogues = $repoMenu->find($id);
            //         }elseif($value->getType() == "burger"){
            //             $catalogues = $repoBurger->find($id);
            //         }
            //     }
            // }
            

        $burgers = $repoBurger -> findAll();
        // dd($burgers[0]);  
        
        //liste menu
        $menus = $repoMenu -> findAll();
        
        //liste complement
        $complement = $repoComplet ->findAll();
        // ajout au panier

        
        return $this->render('client/catalogue.html.twig', [
            'role' => $role,
            'catalogues'=>$catalogue,
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id , BurgerRepository $repoBurger,
                            ComplementRepository $repoComplet,
                            MenusRepository $repoMenu): Response
    {
        $burgers = $repoBurger -> findBy(['etat'=>'non_archiver']);
        $complement = $repoComplet-> findBy(['etat'=>'non_archiver']);
        $menus = $repoMenu -> findBy(['etat'=>'non_archiver']);
        $catalogue = array_merge($burgers , $complement , $menus);

        foreach ($catalogue as $value) {
            if($value->getId()==$id){
                if($value->getType() == "menu"){
                    $details = $repoMenu->find($id);
                }elseif($value->getType() == "burger"){
                    $details = $repoBurger->find($id);
                }
            }
        }
        
        return $this->render('client/details.html.twig', [
            'details'=>$details,
            'type' =>  $details->getType(),
        ]);

    }

    #[Route('/mes_commandes', name: 'mes_commandes')]
    public function showsCommande(CommandeRepository $repoCommande): Response
    {
        $idUser = array_values((array)$this->getUser())[0];
        $commandes = $repoCommande->findBy([
            'user' => $idUser
            
        ]);
    
    return $this->render('client/mes_commandes.html.twig', [
            'commandes' => $commandes,
     ]);
    }
    //ajout commande d'un client







    #[Route('/ajout_commande', name: 'ajout_commande')]
    public function addCommande(CommandeRepository $repoCommande,
                                SessionInterface $session,
                                Request $request,
                                 ): Response


    {

        

        
        
    return $this->render('client/ajout_commande.html.twig', [
            'controller_name' => 'ClientController',
     ]);
    }
}

