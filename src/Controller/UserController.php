<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{

    #[Route('/profil/{name}', name: 'app_profile')]
    public function profile(string $name): Response
    {
        $age = 25;
        $city = "Marseille";
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
            'name' => $name,
            'age' => $age,
            'city' => $city,
        ]);
    }
}
