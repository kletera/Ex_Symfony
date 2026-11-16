<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractController
{
    public function profile(string $name='visiteur'): Response
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
