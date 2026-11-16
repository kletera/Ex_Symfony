<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    // Attribut
    private string $name =  "Alice Martin";
    private int $age = 25;
    private string $city = "Marseille";

    // Getter Setter
    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of age
     *
     * @return int
     */
    public function getAge(): int {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @param int $age
     *
     * @return self
     */
    public function setAge(int $age): self {
        $this->age = $age;
        return $this;
    }

    /**
     * Get the value of city
     *
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param string $city
     *
     * @return self
     */
    public function setCity(string $city): self {
        $this->city = $city;
        return $this;
    }

    // Methode
    #[Route('/profil', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
            'name' => $this->name,
            'age' => $this->age,
            'city' => $this->city,
        ]);
    }
}
