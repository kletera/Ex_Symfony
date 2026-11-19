<?php

namespace App\Service;

use App\Entity\User;
use App\DTO\UserListDTO;
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

    public function getUserListDTOById(int $id): ?UserListDTO
    {
        return $this->userRepository->findOneUserListDTOById($id);
    }

    public function getAllUserListDTO(): array 
    {
        return $this->userRepository->findAllUserListDTO();
    }
}