<?php

namespace App\DataFixtures;

use App\Controller\generateNumeroCommande;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{

    public function __construct( private UserPasswordHasherInterface $hasher){
        $this->encoder=$hasher;

    }

    public function load(ObjectManager $manager): void
    {
        $roles=["ROLE_USER","ROLE_GESTIONNAIRE"];
        // $product = new Product();
        // $manager->persist($product);
        $gestionnaire1 = new User();
        $gestionnaire1->setEmail('gestionnaire@gmail.com');
        $gestionnaire1->setPassword($this->hasher->hashPassword($gestionnaire1,'passer@123'));
        $gestionnaire1->setRoles(['ROLE_GESTIONNAIRE']);
        $gestionnaire1->setNom('Seynabou');
        $gestionnaire1->setPrenom('ka');
        $gestionnaire1->setTelephone('778856131');



        $gestionnaire2 = new User();
        $gestionnaire2->setEmail('gestionnaire2@gmail.com');
        $gestionnaire2->setPassword($this->hasher->hashPassword($gestionnaire2,'passer@123'));
        $gestionnaire2->setRoles(['ROLE_GESTIONNAIRE']);
        $gestionnaire2->setNom('Gestionnaire');
        $gestionnaire2->setPrenom('1');
        $gestionnaire2->setTelephone('778258896');

        $manager->persist($gestionnaire1);
        $manager->persist($gestionnaire2);

       
            $user = new User();
            $user->setEmail("user1@gmail.com");
            $user->setPassword($this->hasher->hashPassword($user,'passer@123'));
            $user->setRoles(['ROLE_USER']);
            $user->setNom('Coudy Ly');
            $user->setPrenom('Wane');
            $user->setTelephone('788346131');


            $manager->persist($user);

        $manager->flush();
    
}
}
