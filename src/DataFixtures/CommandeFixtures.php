<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommandeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $commande = new Commande();
        
        $commande->setNumeroCommande('Commande1');
        $commande->setTelephoneCommande('778864543');
        $commande->setEtatCommande('En cours');
        $commande->setDateCommande('06/06/2022');

        $commande1 = new Commande();

        $commande1->setNumeroCommande('Commande2');
        $commande1->setTelephoneCommande('778804943');
        $commande1->setEtatCommande('En cours');
        $commande1->setDateCommande('07/06/2022');







        $manager->persist($commande);
        $manager->persist($commande1);




        $manager->flush();
    }
}
