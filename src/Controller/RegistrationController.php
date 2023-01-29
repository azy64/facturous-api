<?php

namespace App\Controller;

use App\Entity\Seller;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request ,UserPasswordHasherInterface $passwordHasher, ManagerRegistry $man): Response
    {
        $data = $request->getContent();
        $plainText = $data['motDePass'];
        $seller = new Seller();
        $password = $passwordHasher->hashPassword($seller,$plainText);
        $seller->setPassword($password);
        $manager = $man->getManager();
        $manager->persist($seller);
        $manager->flush();
        return $this->json(['user'=>$seller],200,[],['groups'=>'read:seller:data']);
    }

    
}
