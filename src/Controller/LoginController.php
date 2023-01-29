<?php

namespace App\Controller;

use App\Entity\Seller;
use App\Repository\SellerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'check_login',methods:['POST'])]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if($user){
            return $this->json(['user' => $user], 200, [], ['groups' => 'read:seller:data']);
        }
        return $this->json(['message' => 'missing credentials',], Response::HTTP_UNAUTHORIZED);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    public function __invoke(SellerRepository $sellerRepository,Security $security,$data)
    {
        $user = $security->getUser();
        if ($user)
            return $this->json(['user' => $user]);
        return $this->json(['user' => []]);
    }
}
