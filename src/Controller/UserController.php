<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends AbstractController
{

    public function __construct(private UserService $userService) {}

    #[Route('/users', name: 'app_users')]
    #[IsGranted('IS_AUTHENTICATED_FULLY', message: 'Vous n\'est pas autorisé')]
    public function index(): Response
    {
        return $this->render('user/show_all_user.html.twig', [
            'users' => $this->userService->getAllUser(),
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY', message: 'Vous n\'est pas autorisé')]
    public function showProfil(#[CurrentUser] User $user): Response
    {

        return $this->render('user/show_user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit', methods: ["GET", "POST"])]
    #[IsGranted('ROLE_USER', message: 'Vous n\'est pas autorisé')]
    public function editProfil(#[CurrentUser] User $user, Request $request): Response
    {


        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->userService->saveUser($user);

            $this->addFlash('notice', "L'utilisateur a été mis a jour");

            return $this->redirectToRoute('app_profile_edit');
        }

        return $this->render('user/form_profile.html.twig', [
            'form' => $form,
        ]);
    }
}
