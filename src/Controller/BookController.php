<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    private array $books = [
        ['id' => 1, 'title' => 'Dune', 'author' => 'Frank Herbert'],
        ['id' => 2, 'title' => '1984', 'author' => 'George Orwell'],
        ['id' => 3, 'title' => 'Fondation', 'author' => 'Isaac Asimov'],
    ];
    #[Route('/livres', name: 'app_books')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'books' => $this->books,
        ]);
    }
    #[Route('/livres/{id}', name: 'app_book_show')]
    public function show(int $id):Response{
        $book=null;

        foreach ($this->books as $b) {
            if ($b['id'] === $id) {
                $book = $b;
                break;
            }
        }
        if ($book === null) {
            throw $this->createNotFoundException('Erreur 404 : Livre introuvable.');
        }
        return $this->render('book/show.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
        ]);
    }
}
