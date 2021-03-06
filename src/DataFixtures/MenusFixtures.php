<?php

namespace App\DataFixtures;

use App\Entity\Menus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $menus = new Menus();
            $menus->setNom('Menu Simple');
            $menus->setPrix('3500 Fcfa');
            $menus->setDetail('Burgers, Frites et Boisson');

            $manager->persist($menus);

            $this->addReference("menus", $menus);

            $menus1 = new Menus();
            $menus1->setNom('Menu Royale');
            $menus1->setPrix('4000 Fcfa');
            $menus1->setDetail('Burgers + Crudite + Salade
                                    , Frites et Boisson');

            $manager->persist($menus1);

            $this->addReference("menus1", $menus1);


        $manager->flush();
    }
}
