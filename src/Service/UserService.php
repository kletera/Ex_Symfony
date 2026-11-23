<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em
    ) {}

    public function getAllUser()
    {
        return $this->userRepository->findAll() ?? [];
    }


    public function saveUser(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
