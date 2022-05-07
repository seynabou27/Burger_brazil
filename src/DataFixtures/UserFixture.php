<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{

    public function __construct( private UserPasswordHasherInterface $hasher){}

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $gestionnaire1 = new User();
        $gestionnaire1->setEmail('gestionnaire@gmail.com');
        $gestionnaire1->setPassword($this->hasher->hashPassword($gestionnaire1,'passer@123'));
        $gestionnaire1->setRoles(['ROLE_GESTIONNARE']);

        $gestionnaire2 = new User();
        $gestionnaire2->setEmail('gestionnaire2@gmail.com');
        $gestionnaire2->setPassword($this->hasher->hashPassword($gestionnaire2,'passer@123'));
        $gestionnaire2->setRoles(['ROLE_GESTIONNARE']);

        $manager->persist($gestionnaire1);
        $manager->persist($gestionnaire2);

        for ($i=1; $i<=5;$i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $user->setPassword($this->hasher->hashPassword($user,'passer@123'));
            $manager->persist($user);

        $manager->flush();
    }
}
}
