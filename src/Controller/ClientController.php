<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Image;
use App\Entity\Paiement;
use App\Repository\MenusRepository;
use App\Repository\BurgerRepository;
use App\Repository\CommandeRepository;
use App\Repository\ComplementRepository;
use App\Repository\PaiementRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/catalogue/tout/{type}', name: 'catalogue_tout')]
    public function catalogueTout($type, Request $request, Session $session): Response
    {
        $session->set('typeFood1', $request->get('type'));
        return new JsonResponse($this->generateUrl('catalogue'));
    }


    #[Route('/catalogue/burger/{type}', name: 'catalogue_burger')]
    public function catalogueBurger($type, Request $request, Session $session): Response
    {
        $session->set('typeFood2', $request->get('type'));
        return new JsonResponse($this->generateUrl('catalogue'));
    }

    #[Route('/catalogue/menus/{type}', name: 'catalogue_menus')]
    public function catalogueMenus($type, Request $request, Session $session): Response
    {
        $session->set('typeFood', $request->get('type'));
        return new JsonResponse($this->generateUrl('catalogue'));
    }
    

    #[Route('/', name: 'catalogue')]
    public function catalogue(
        ?int $id,
        BurgerRepository $repoBurger,
        MenusRepository $repoMenu,
        ComplementRepository $repoComplet,
        Request $request
    ): Response {
        if ($this->getUser()) {
            $role = $this->getUser()->getRoles()[0];
        } else {
            $role = "";
        }

        // dd($complements);

        $burgers = $repoBurger->findBy(['etat' => 'non_archiver']);
        $menus = $repoMenu->findBy(['etat' => 'non_archiver']);
        $catalogue = array_merge($menus, $burgers);

        $session = $request->getSession();
        if ($session->has('typeFood')) {
            $typeFood = $session->get('typeFood');
            if ($typeFood == 'menu') {
                $catalogue = $menus;
            }
            $session->remove('typeFood');
            return $this->render('client/catalogue.html.twig', [
                'role' => $role,
                'typeSelected' => $typeFood,
                'catalogues' => $catalogue,
                'success' => $session->get('success'),
                'removeSucess' => $session->remove('success'),
            ]);
        }

        
        if ($session->has('typeFood2')) {
            $typeFood1 = $session->get('typeFood2');
            if ($typeFood1 == 'burger') {
                $catalogue = $burgers;
            }
            $session->remove('typeFood2');
            return $this->render('client/catalogue.html.twig', [
                'role' => $role,
                'typeSelected' => $typeFood1,
                'catalogues' => $catalogue,
                'success' => $session->get('success'),
                'removeSucess' => $session->remove('success'),
            ]);
        }

        if ($session->has('typeFood1')) {
            $typeFood1 = $session->get('typeFood1');
            
            $session->remove('typeFood1');
            return $this->render('client/catalogue.html.twig', [
                'role' => $role,
                'typeSelected' => $typeFood1,
                'catalogues' => $catalogue,
                'success' => $session->get('success'),
                'removeSucess' => $session->remove('success'),
            ]);
        }

        
        

        return $this->render('client/catalogue.html.twig', [
            'role' => $role,
            'catalogues' => $catalogue,
            'success' => $session->get('success'),
            'removeSucess' => $session->remove('success'),
        ]);
    }
    //Detail des commandes
    #[Route('/details/{id}', name: 'details')]
    public function details(
        int $id,
        BurgerRepository $repoBurger,
        ComplementRepository $repoComplet,
        MenusRepository $repoMenu
    ): Response {

        $burgers = $repoBurger->findBy(['etat' => 'non_archiver']);
        $complement = $repoComplet->findBy(['etat' => 'non_archiver']);
        $menus = $repoMenu->findBy(['etat' => 'non_archiver']);
        $catalogue = array_merge($burgers, $complement, $menus);

        foreach ($catalogue as $value) {
            if ($value->getId() == $id) {
                if ($value->getType() == "menu") {
                    $details = $repoMenu->find($id);
                } elseif ($value->getType() == "burger") {
                    $details = $repoBurger->find($id);
                }
            }
        }

        return $this->render('client/details.html.twig', [
            'details' => $details,
            '::type' =>  $details->getType(),
        ]);
    }
    #[Route('/detail', name: 'details_commande')]
    public function details_commande(
        BurgerRepository $repoBurger,
        ComplementRepository $repoComplet,
        Request $request,
        PaiementRepository $paiementrepo,
        EntityManagerInterface $manager,
        MenusRepository $repoMenu,
        CommandeRepository $commandeRepo
    ): Response {

        $session = $request->getSession();
        //dd($session->get("paiements"));
        $payer = $session->get("payer");
        $method = $request->getMethod();
        if ($method == 'POST') {
            foreach ($payer as $value) {
                $oneCommande = $commandeRepo->find($value);
                $oneCommande->setEtatCommande('payer');
                $paiements[] = $oneCommande;
            }
           
            foreach ($paiements as $val) {
                $commandeValider[] = [
                    'paiement' => $paiementrepo->find($val->getPaiements()),
                    'montant' => $val->getMontant()

                ];
            }
          //  dd($commandeValider);
            // dd($val1);
            foreach ($commandeValider as $val1) {
                $val1['paiement']->setMontant($val1['montant']);
                $manager->persist($val1['paiement']);
                $manager->flush();
            }
            return $this->redirectToRoute('mes_commandes');
        }
    }

    #[Route('/mes_commandes', name: 'mes_commandes')]
    public function showsCommande(CommandeRepository $repoCommande, PaginatorInterface $paginator, Request $request): Response
    {
        $idUser = array_values((array)$this->getUser())[0];

        $commandes = $paginator->paginate(

            $commandeClient = $repoCommande->findBy(['user' => $idUser], ['id' => 'DESC']),

            $request->query->getInt('page', 1),
            3

        );
        // dd($commandes);


        $session = $request->getSession();


        return $this->render('client/mes_commandes.html.twig', [
            'commandes' => $commandes,
            'success' => $session->get('success'),
            'removeSucess' => $session->remove('success'),


        ]);
    }
    // payement commande

    #[Route('/paiement', name: 'imam')]
    public function imam(
        CommandeRepository $repoCommande,
        PaginatorInterface $paginator,
        Request $request,
        PaiementRepository $paiementrepo,
        EntityManagerInterface $manager
    ): Response {
        $data = $request->request->all();
        extract($data);
        //dd($payer);
        if (isset($payer)) {
            foreach ($payer as $value) {
                $paiements[] = $repoCommande->find($value);
            }
            // dd($paiements);


            // dd($paiements);

            $session = $request->getSession();
            $session->set('payer', $payer);

            return $this->render('client/details_commande.html.twig', [
                'paiements' => $paiements,
            ]);
        }
        return $this->redirectToRoute('mes_commandes');
    }







    #[Route('/ajout_commande', name: 'ajout_commande')]
    public function addCommande(
        CommandeRepository $repoCommande,
        SessionInterface $session,
        Request $request,
    ): Response {





        return $this->render('client/ajout_commande.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/Liste_valide', name: 'etat_valide')]
    public function etatsValider(CommandeRepository $commandeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $commandes = $paginator->paginate(

            $valider = $commandeRepository->findBy(['etat_commande' => 'Valid??e']),
            $request->query->getInt('page', 1),
            3

        );



        return $this->render('client/liste_valide.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/Liste_Encours', name: 'etat_encours')]
    public function etatsEncours(CommandeRepository $commandeRepository): Response
    {


        $commandes = $commandeRepository->findBy(['etat_commande' => 'En cours']);

        return $this->render('client/liste_encours.html.twig', [
            'commandes' => $commandes
        ]);
    }
    #[Route('/Liste_Annules', name: 'etat_annules')]
    public function etatsAnnuler(CommandeRepository $commandeRepository): Response
    {


        $commandes = $commandeRepository->findBy(['etat_commande' => 'Annul??e']);

        return $this->render('client/liste_annule.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/Liste_Payer', name: 'etat_payer')]
    public function etatspayer(CommandeRepository $commandeRepository): Response
    {


        $commandes = $commandeRepository->findBy(['etat_commande' => 'Payer']);

        return $this->render('client/liste_payer.html.twig', [
            'commandes' => $commandes
        ]);
    }
}
