<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GetUserEmailController extends AbstractController
{
    /**
     * @Route("/get/user/email/{userId}", name="app_get_user_email", methods={"GET"})
     */
    public function index(int $userId, UserRepository $userRepository)
    {
        $user = $userRepository->findOneBy([
            'id' => $userId,
        ]);
    
        if (!isset($user)) {
            return $this->json(['email' => 'user not found']);
        }
        
        return $this->json(['email' => $user->getEmail()]);
    }
}
