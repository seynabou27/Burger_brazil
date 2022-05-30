<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Paiement;
use App\Repository\BurgerRepository;
use App\Repository\CommandeRepository;
use App\Repository\MenusRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Command\Command;

// /**
//  *
//  * @IsGranted("ROLE_USER")
//  */
class BurgerController extends AbstractController
{
    /**
 * @Route("/panier", name="panier")
 */

    #[Route('/burger/{id}', name: 'app_burger')]
    public function index(?int $id ,Request $request,BurgerRepository $burger,
                            MenusRepository $repoMenus,
                            CommandeRepository $repoCommande
                            , UserRepository $userRepo,
                            EntityManagerInterface $entityManager): Response
    {
        $method = $request->getMethod(); 

        $commande = new Commande();

         $paiement= new Paiement();


        $session = $request ->getSession();

        $panier =$session->get('panier',[]);
        // pour enrechir le panier
        $panierData = [];
        $idMenus = [];
        $idBurgers = [];
        foreach ($panier as $id => $quantite) {
            if(str_contains($id , 'burger')){
                $idBurgers [] = (int) filter_var($id , FILTER_SANITIZE_NUMBER_INT);
            }else{
                $idMenus [] = (int) filter_var($id , FILTER_SANITIZE_NUMBER_INT);
            }
            $panierData [] = [
                'burger'=> str_contains($id , 'burger')? $burger->find($id):$repoMenus->find($id),
                'quantite'=> $quantite,
                


            ];
        }

        //panier
        
        $total = 0;
        foreach ($panierData as $item ) {

            $totalitem = $item['burger']->getPrix() * $item['quantite'];
            $total +=$totalitem;
        }

        if ($method == 'POST') {
            $date = date_format(date_create() , 'Y-m-d');
            $idUser = array_values((array)$this->getUser())[0];
            $commandes = $repoCommande->findBy([
                'user' => $idUser
            ]);
            $user = $userRepo->find($idUser);

            $paiement->setMontant(0);
            $commande->setDateCommande($date) 
                    ->setNumeroCommande(rand())
                    ->setUser($this->getUser())
                    ->setTelephoneCommande($user->getTelephone())
                    ->setPaiements($paiement);
            if(count($idBurgers)>0){
                foreach ($idBurgers as $val) {
                    $commande->addBurger($burger->find($val));
                }
            }       
            if(count($idMenus)>0){
                foreach ($idMenus as $val2) {
                    $commande->addMenu($repoMenus->find($val2));
                }
            } 
               
            $entityManager->persist($paiement);
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute("mes_commandes");
        }

       

        
        // dd($panierwithData);
        return $this->render('burger/index.html.twig', [
            'item' => $panierData,
            'total'=> $total,
        ]);
    }
    public function getTotal() : float{
        $total = 0;
       
        // foreach($this->getFullCart() as $item)
        // {
        //     $total += $item['burger']->getPrix() * $item['quantite'];
        // }
       
            return $total;
          }

    /**
     * @Route("/panier/add/{id}", name="add_panier")
    */

    public function add($id, Request $request, BurgerRepository $burger,
                        MenusRepository $repoMenus,
                        CommandeRepository $repoCommande){
        $session = $request ->getSession();

        $panier= $session->get('panier',[]);

        if (!empty ($panier[$id])){

            $panier[$id] ++;



        }else {
            $panier[$id] =1;
            // $this->addFlash('success', 'Article Created! Knowledge is power!');


        }


        

        $session->set('panier' ,$panier);
        
        $session->set('sucess' ,"Ajouter avec succes!!");


        //dd($session->get('panier'));
        return $this->redirectToRoute("catalogue");


    }

    /**
     * @Route("/panier/remove/{id}", name="remove")
    */

    public function remove($id, Request $request){
     
        $session = $request ->getSession();

        $panier =$session->get('panier',[]);

        if (!empty($panier[$id])) {
            // die('ok');
   
            unset($panier[$id]);

        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");

    }

 
 /**
     * @Route("/panier/plus/{id}", name="plus")
    */

    public function plus($id, Request $request, BurgerRepository $burger,
                        MenusRepository $repoMenus,
                        CommandeRepository $repoCommande){
        $session = $request ->getSession();

        $panier= $session->get('panier',[]);

        if (!empty ($panier[$id])){

            $panier[$id] ++;


        }else {
            $panier[$id] =1;

        }

        

        $session->set('panier' ,$panier);

        //dd($session->get('panier'));
        return $this->redirectToRoute("panier");


    }
    /**
     * @Route("/panier/moins/{id}", name="moins")
    */

    public function moins($id, Request $request, BurgerRepository $burger,
                        MenusRepository $repoMenus,
                        CommandeRepository $repoCommande){
        $session = $request ->getSession();

        $panier= $session->get('panier',[]);

        if (!empty ($panier[$id])){

            $panier[$id] --;
            if($panier[$id]){
                $this->remove($id, $request);
            }

        }else {
            $panier[$id] = 1;

        }

        

        $session->set('panier' ,$panier);

        //dd($session->get('panier'));
        return $this->redirectToRoute("panier");


    }



}
