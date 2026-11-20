<?php

namespace App\Controller;

use App\DTO\BookListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\BookService;

final class BookController extends AbstractController
{
    private array $books = [
        ['id' => 1, 'title' => 'Dune', 'author' => 'Frank Herbert'],
        ['id' => 2, 'title' => '1984', 'author' => 'George Orwell'],
        ['id' => 3, 'title' => 'Fondation', 'author' => 'Isaac Asimov'],
    ];

     // Construct
    public function __construct(private BookService $bookService)
    {}

    // Methode
    #[Route('/books', name: 'app_books')]
    public function index(): Response
    {
        return $this->render('book/show_all_books.html.twig', [
            'controller_name' => 'BookController',
            'books' => $this->bookService->getBooks(),
        ]);
    }
    #[Route('/books/{id}', name: 'app_book_id')]
    public function showBookById(int $id):Response{
        // $book=null;
        // foreach ($this->books as $b) {
        //     if ($b['id'] === $id) {
        //         $book = $b;
        //         break;
        //     }
        // }

        $book=$this->bookService->getBookById($id);

        if ($book === null) {
            throw $this->createNotFoundException('Erreur 404 : Livre introuvable.');
        }
        return $this->render('book/show_book_id.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
        ]);
    }

    #[Route('/books/{title}', name: 'app_book_title')]
    public function showBookByTitle(string $title): Response{

        $book = $this->bookService->getBookByTitle($title);
        if ($book === null) {
            throw $this->createNotFoundException('Erreur 404 : Livre introuvable.');
        }

        return $this->render('book/show_book_title.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/books/search/{title}', name: 'app_book_search_title')]
    public function searchBooksByTitle(string $title):Response{

        return $this->render('book/search_book_title.html.twig', [
            'books' => $this->bookService->getBookByTitleRepo($title),
        ]);
    }

    #[Route('/books/recent/{date}', name: 'app_book_recent')]
    public function showBookByDate(string $date ):Response{

        return $this->render('book/show_book_date.html.twig', [
            'books' => $this->bookService->getBookBDate($date),
        ]);
    }

    #[Route('/books/category/{categoryName}', name: 'app_book_category')]
    public function showBookByCategories(string $categoryName ):Response{

        return $this->render('book/show_book_category.html.twig', [
            'books' => $this->bookService->getBookByCategories($categoryName),
        ]);
    }

    #[Route('/books/dto', name: 'app_book_dto')]
    public function showBookListDto():Response{

        return $this->render('book/show_book_date.html.twig', [
            'books' => $this->bookService->getBookListDto(),
        ]);
    }
}
