<?php

namespace App\Service;

use App\DTO\BookListDto;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService{
    public function __construct(
        private BookRepository $bookRepository,
        private EntityManagerInterface $em
        )
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

    public function getBookBDate(string $date): array{
        $date= new \DateTimeImmutable($date);

        return $this->bookRepository->findPublishedAfter($date);
    }

    public function getBookByCategories(string $categoryName): array{

        $categoryName= explode(',',$categoryName);

        return $this->bookRepository->findByCategory($categoryName);
    }

    public function getBookListDto(): array{
        return $this->bookRepository->findBookListDto();
    }

    public function saveBook(Book $book): void{
        $this->em->persist($book);
        $this->em->flush();
    }

    public function deleteBook(Book $book): void{
        $this->em->remove($book);
        $this->em->flush();
    }
}