<?php

namespace App\DataFixtures;

use App\Entity\Seller;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct( private UserPasswordHasherInterface $passwordHasher) {

    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new Seller();
        $user->setMotDePasse("xxxxxx89")
            ->setEmail('allysaidi64@gmail.com')
            ->setAdresseFacturation("136 rue des Murlins 45000, Orleans")
            ->setAdresseSiege("136 rue des Murlins 45000, Orleans")
            ->setCodePostale("45000")
            ->setDenomination("Tunaweza")
            ->setNom("SAIDI")
            ->setPrenom("AZARIA")
            ->setRoles(["ROLE_ADMIN", "ROLE_USER"])
            ->setVille('ORLEANS')
            ->setRcs("09875456- france")
            ->setSiren("09875456")
            ->setSiret("0987545687634");
        $password = $this->passwordHasher->hashPassword($user, $user->getMotDePasse());
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
    }
}
