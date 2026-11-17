<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;

final class UserController extends AbstractController
{
    // Construct
    public function __construct(private UserService $userService)
    {}

    // Methode
    #[Route('/profil/{name}', name: 'app_profile')]
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
    
    // Affichage de tous les utilisateur
    #[Route('/users', name: 'app_users')]
    public function showAllUser(){
        return $this->render('user/show_all_user.html.twig', [
            'users'=> $this->userService->getUsers(),
        ]);
    }

    // Affichage de l'utilisateur en fonction de son identifiant numérique
    #[Route('/users/{id}', name: 'app_user_id')]
    public function showUserById(int $id){
        $user=null;
        $user=$this->userService->getUserById($id);
        if ($user === null) {
            throw $this->createNotFoundException('Erreur 404 : Utilisateur introuvable.');
        }
        return $this->render('user/show_user_id.html.twig', [
            'user'=> $user,
        ]);
    }
}
