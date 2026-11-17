<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService{
     public function __construct(private UserRepository $userRepository)
    {}

    public function getUsers(){
        return $this->userRepository->findAll() ?? [];
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
}