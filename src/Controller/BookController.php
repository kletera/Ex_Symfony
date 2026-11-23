<?php

namespace App\Controller;

use App\DTO\BookListDto;
use App\Entity\Book;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\BookService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
    #[IsGranted('IS_AUTHENTICATED_FULLY', message:'Vous n\'est pas autorisé')]
    public function index(): Response
    {
        return $this->render('book/show_all_books.html.twig', [
            'controller_name' => 'BookController',
            'books' => $this->bookService->getBooks(),
        ]);
    }
    #[Route('/books/{id}', name: 'app_book_id', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
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

    // #[Route('/books/{title}', name: 'app_book_title', requirements: ['title' => '[a-zA-Z]+'])]
    // #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    // public function showBookByTitle(string $title): Response{

    //     $book = $this->bookService->getBookByTitle($title);
    //     if ($book === null) {
    //         throw $this->createNotFoundException('Erreur 404 : Livre introuvable.');
    //     }

    //     return $this->render('book/show_book_title.html.twig', [
    //         'book' => $book,
    //     ]);
    // }

    #[Route('/books/search/{title}', name: 'app_book_search_title', requirements: ['title' => '[a-zA-Z]+'])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function searchBooksByTitle(string $title):Response{

        return $this->render('book/search_book_title.html.twig', [
            'books' => $this->bookService->getBookByTitleRepo($title),
        ]);
    }

    #[Route('/books/recent/{date}', name: 'app_book_recent',  requirements: ['date' => '[^/]+'])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function showBookByDate(string $date ):Response{

        return $this->render('book/show_book_date.html.twig', [
            'books' => $this->bookService->getBookBDate($date),
        ]);
    }

    #[Route('/books/category/{categoryName}', name: 'app_book_category', requirements: ['categoryName' => '[a-zA-Z]+'])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function showBookByCategories(string $categoryName ):Response{

        return $this->render('book/show_book_category.html.twig', [
            'books' => $this->bookService->getBookByCategories($categoryName),
        ]);
    }

    #[Route('/books/dto', name: 'app_book_dto')]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function showBookListDto():Response{

        return $this->render('book/show_book_date.html.twig', [
            'books' => $this->bookService->getBookListDto(),
        ]);
    }

    #[Route('/books/new', name: 'app_book_new', methods:["GET", "POST"])]
    #[IsGranted('ROLE_ADMIN', message:'Vous n\'est pas autorisé')]
    public function new(Request $request):Response{
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $this->bookService->saveBook($book);

            $this->addFlash('notice', 'Le livre a été ajouter');

            return $this->redirectToRoute('app_book_new');
        }

        return $this->render('book/book_form.html.twig', [
            'form'=> $form
        ]);
    }

    #[Route('/books/{id}/edit', name:'app_book_edit', requirements: ['id' => '\d+'], methods:["GET", "POST"])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function editBookById(int $id, Request $request): Response{

        $book=$this->bookService->getBookById($id);
        if($book === null){
             $this->addFlash('notice', "Le livre n'existe pas");

            return $this->redirectToRoute('app_book_new');
        }

        $form = $this->createForm(BookType::class, $book, [
            'label_save_edit'=>'Modifier'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $this->bookService->saveBook($book);

            $this->addFlash('notice', 'Le livre a été modifier');

            return $this->redirectToRoute('app_book_edit',[ 'id'=>$id]);
        }

        return $this->render('book/book_form.html.twig', [
            'form'=> $form
        ]);
    } 
}
