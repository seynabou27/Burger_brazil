<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // $image = new Image();
        
        // $image->setNom('image1');

        // $image->setBurger('1');

        // $manager->persist($image);


        $manager->flush();
    }
}
