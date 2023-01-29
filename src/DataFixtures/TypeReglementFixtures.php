<?php

namespace App\DataFixtures;

use App\Entity\EtatFacture;
use App\Entity\TypeReglement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeReglementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $reglement = ["CB", "Chèque", "payPal", "VISA", "MASTER CARD"];
        $etatFac = ["Reglé", "Non reglé", "Reglé en partie"];
        for ($i = 0; $i < 5;$i++){
            $typeReglement = new TypeReglement();
            $typeReglement->setLibelle($reglement[$i]);
            $manager->persist($typeReglement);
            if($i<3){
                $etatFacture = new EtatFacture();
                $etatFacture->setLibelle($etatFac[$i]);
                $manager->persist($etatFacture);
            }
        }
        $manager->flush();
    }
}
