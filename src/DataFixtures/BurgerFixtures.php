<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BurgerFixtures extends Fixture
{
    public function __construct( private UserPasswordHasherInterface $hasher){}

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <=1; $i++) {

            $burger = new Burger();
            $burger->setNom('Cheese Burgers'.$i);
            $burger->setPrix('2500 Fcfa');
            $burger->setDetails('Cheese Burgers, est composé de deux pains de forme ronde 
                                garnis de steak haché et de crudités, 
                                salade, tomate…');

            $manager->persist($burger);

            $this->addReference("burger".$i, $burger);

        }

        $burger2 = new Burger();
            $burger2->setNom('Burger Royal');
            $burger2->setPrix('3000 Fcfa');
            $burger2->setDetails('Burger Royal, est composé de deux pains de forme ronde 
                                garnis de steak haché et de crudités, 
                                salade, tomate…');

            $manager->persist($burger2);

            // $this->addReference("burger1", $burger2);


            $burger3 = new Burger();
            $burger3->setNom('Burger Simple');
            $burger3->setPrix('2000 Fcfa');
            $burger3->setDetails('Burger Simple, est composé de deux pains de forme ronde 
                                garnis de steak haché et salade');

            $manager->persist($burger3);

            // $this->addReference("burger3", $burger3);


            

        $manager->flush();
    }
}
