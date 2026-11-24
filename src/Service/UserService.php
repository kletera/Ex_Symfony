<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserRepository $userRepository,
        private readonly ValidatorInterface $validator
    ) {}

    public function getAllUser(){
        return $this->userRepository->findAll() ?? [];
    }

    public function saveUser(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
