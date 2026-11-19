<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookService{
    public function __construct(private BookRepository $bookRepository)
    {}

    public function getBooks(){
        return $this->bookRepository->findAll() ?? [];
    }

    public function getBookById(int $id): ?Book
    {
        return $this->bookRepository->find($id);
    }

    public function getBookByTitle(string $title): ?Book{
        return $this->bookRepository->findOneBy(['title'=> $title]);
    }

    public function getBookByTitleRepo(string $title): array{
        return $this->bookRepository->findByTitle($title);
    }
}