<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// /**
//  *
//  * @IsGranted("ROLE_USER")
//  */
class BurgerController extends AbstractController
{
    /**
 * @Route("/panier", name="panier")
 */
    #[Route('/burger', name: 'app_burger')]
    public function index(  Request $request,BurgerRepository $burger): Response
    {
        $session = $request ->getSession();

        $panier =$session->get('panier',[]);
        // pour enrechir le panier
        $panierwithData = [];
        foreach ($panier as $id => $quantite) {

            $panierwithData [] = [
                'burger' => $burger->find($id),
                'quantite'=> $quantite,
            ];
        }

        $total = 0;
        foreach ($panierwithData as $item ) {

            $totalitem = $item['burger']->getPrix() * $item['quantite'];
            $total +=$totalitem;
        }
        // dd($panierwithData);
        return $this->render('burger/index.html.twig', [
            'item' => $panierwithData,
            'total'=> $total,
        ]);
    }

     /**
 * @Route("/panier/add{id}", name="add_panier")
 */

    public function add($id, Request $request){
        $session = $request ->getSession();

        $panier= $session->get('panier',[]);

        if (!empty ($panier[$id])){

            $panier[$id] ++;


        }else {
            $panier[$id] =1;

        }



        $session->set('panier' ,$panier);

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
        unset($panier[$id]);

    }
    $session->set('panier', $panier);

    return $this->redirectToRoute("panier");

 }



}
