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
            $complement->setNom('Frites');
            $complement->setPrix('1000 Fcfa');
            $complement->setDetail('poivre , sale, piment');

            $manager->persist($complement);

            $this->addReference("complement", $complement);


            $complement1 = new Complement();
            $complement1->setNom('Boisson');
            $complement1->setPrix('1000 Fcfa');
            $complement1->setDetail('Fanta, Sprite,Coca');

            $manager->persist($complement1);

            $this->addReference("complement1", $complement1);



        $manager->flush();
    }
}
