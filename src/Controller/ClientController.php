<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function catalogue(BurgerRepository $repoBurger,Request $request): Response
    {
        if($this->getUser()){
            $role = $this->getUser()->getRoles()[0];
        }else{
            $role = "";
        }
        $burgers = $repoBurger -> findAll();
        // dd($burgers[0]);   
        return $this->render('client/catalogue.html.twig', [
            'role' => $role,
            'burger' =>$burgers,
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id , BurgerRepository $repoBurger): Response
    {
        
        $burgers = $repoBurger -> findBy(["id"=>$id]);
        return $this->render('client/details.html.twig', [
            'burgers'=>$burgers,
        ]);

        /* return $this->render('client/details.html.twig', [
            'controller_name' => 'ClientController',
        ]); */
    }

    #[Route('/mes_commandes', name: 'mes_commandes')]
    public function showsCommande(): Response
    {

        
 return $this->render('client/mes_commandes.html.twig', [
            'controller_name' => 'ClientController',
     ]);
    }
}
