<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Menus;
use App\Entity\Burger;
use App\Form\MenuType;
use App\Form\BurgerType;
use App\Entity\Complement;
use App\Form\ComplementType;
use App\Repository\MenusRepository;
use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    #[Route('/produit/editer/{id}', name: 'editer_produit')]
    public function addProduit(?Burger $burger,Request $request,EntityManagerInterface $entityManager): Response
    {
        //Ajout burger
        if (!$burger) {
            $burger = new Burger();
        }
        $form = $this->createForm(BurgerType::class, $burger);
        //recuperer les données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperer les images transmises
            $images = $form->get('images')->getData();

            foreach ($images as $image) {
                //genere un nouveau de nom de fichier
                $fichier = md5(uniqid()). '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donneé (son nom)
                $img = new Image();
                $img->setNom($fichier);
                $burger-> addImage($img);


            }
            $burger = $form->getData();
            
            $entityManager->persist($burger);
            $entityManager->flush();           

            return $this->redirectToRoute('produit',['id'=>$burger->getId()]);
        }
        return $this->render('gestionnaire/ajout_produit.html.twig', [
            'burgerForm' => $form->createView(),
            'editerBurger' => $burger->getId(),

        ]);
    
    }

    #[Route('/ajout_complement', name: 'ajout_complement')]
    #[Route('/ajout_complement/editer/{id}', name: 'editer_complement')]
    public function addComplement(?Complement $complement, Request $request,EntityManagerInterface $entityManager): Response
    {
        if (!$complement) {

            $complement = new Complement();
        }
        // //ajout complement ComplementType
        
        $form = $this->createForm(ComplementType::class, $complement);
        //recuperer les données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperer les images transmises
            $images = $form->get('images')->getData();

            foreach ($images as $image) {
                //genere un nouveau de nom de fichier
                $fichier = md5(uniqid()). '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donneé (son nom)
                $img = new Image();
                $img->setNom($fichier);
                $complement-> addImage($img);


            }
            $complement = $form->getData();
            
            $entityManager->persist($complement);

            $entityManager->flush();
           
            return $this->redirectToRoute('produit', ['id'=>$complement->getId()]);
       }


        return $this->render('gestionnaire/ajout_complement.html.twig', [
            'complementForm' => $form->createView(),
            'editerComplement' => $complement ->getId(),
        ]);
    
    }

    #[Route('/ajout_menu', name: 'ajout_menu')]
    #[Route('/ajout_menu/editer/{id}', name: 'editer_menu')]

    public function addMenus(?Menus $menus,Request $request,
                            EntityManagerInterface $entityManager , 
                            BurgerRepository $repoburger,
                            ComplementRepository $repoComplet): Response
    {
        if (!$menus) {
            $menus = new Menus();
        }
        $datas = $request->request->all();
        extract($datas);
        
        $burger = $repoburger -> findAll();
        $complement =$repoComplet->findBy(['etat'=>'non_archiver']);
        // dd($complement);
        $form = $this->createForm(MenuType::class, $menus);
        //recuperer les données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             //recuperer les images transmises
            $images = $form->get('images')->getData();
            // dd($complements);
            foreach ($images as $imagess) {
                //genere un nouveau de nom de fichier
                $fichier = md5(uniqid()). '.' . $imagess->guessExtension();
                $imagess->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donneé (son nom)
                $img = new Image();
                $img->setNom($fichier);
                $menus-> addImagess($img);
 
 
             }
            foreach ($complements as  $value) {
                $complementChecked = $repoComplet->find($value);
                $menus->addComplement($complementChecked);
            }
            $menus = $form->getData();
             
            
            $entityManager->persist($menus);

            $entityManager->flush();
           
            return $this->redirectToRoute('produit',['id'=>$menus->getId()]);
        }


        return $this->render('gestionnaire/ajout_menu.html.twig', [
            'menuForm' => $form->createView(),
            'burger' => $burger,
            'editerMenus'=>$menus->getId(),
            'complement'=>$complement,

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
                                MenusRepository $repoMenu,
                                PaginatorInterface $paginator): Response

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

        //pagination des produits
         $produit =   array_merge($burger,$menus , $complement);
        //  dd($produit);
            
        // $ingredients = $paginator->paginate(
        //     $repository->findBy(['user' => $this->getUser()]),
        //     $request->query->getInt('page', 1),
        //     10
        // );


        return $this->render('gestionnaire/produit.html.twig', [
            'role' =>  $role,
            'burger' => $burger,
            'menus'=> $menus,
            'complement'=> $complement,
            'produit'=>$produit,

        ]);
    }
    

}
