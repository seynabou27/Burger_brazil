<?php

namespace App\DataFixtures;

use App\Entity\Complement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ComplementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $complement = new Complement();
            $complement->setNomComplement('Frites');
            $complement->setPrixComplement('1000 Fcfa');
            $complement->setDetailComplement('poivre , sale, piment');

            $manager->persist($complement);

            $this->addReference("complement", $complement);


            $complement1 = new Complement();
            $complement1->setNomComplement('Boisson');
            $complement1->setPrixComplement('1000 Fcfa');
            $complement1->setDetailComplement('Fanta, Sprite,Coca');

            $manager->persist($complement1);

            $this->addReference("complement1", $complement1);



        $manager->flush();
    }
}
