<?php

namespace App\Tests\Unit\Service;

use App\Entity\Book;
use App\Service\BookService;
use App\Repository\BookRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class BookServiceTest extends TestCase{
    // Methode
    public function testGetCategoriesReturnsById():void{
        // Arrange
        $book = (new Book())->setTitle('Dune');
        $repository = $this->createStub(BookRepository::class);
        $repository->method('find')->willReturn($book);
        $em = $this->createStub(EntityManagerInterface::class);
        $service = new BookService($repository, $em);

        // Act
        $actual = $service->getBookById(42);

        // Assert
        self::assertSame($book, $actual);
    }

    public function testGetCategoriesReturnsNull():void{
        // Arrange
        $repository = $this->createStub(BookRepository::class);
        $repository->method('find')
            ->willReturn(null);
        $em = $this->createStub(EntityManagerInterface::class);
        $service = new BookService($repository, $em);
        
        // Act
        $actual = $service->getBookById(404);
        
        // Assert
        self::assertNull($actual);
    }
}