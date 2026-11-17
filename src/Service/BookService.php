<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookService{
    public function __construct(private BookRepository $bookRepository)
    {}

    public function getBook(){
        
    }
}