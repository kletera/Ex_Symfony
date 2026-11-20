<?php

namespace App\DTO;

use DateTimeInterface;
use App\Entity\Book;

final class BookListDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $title,
        public readonly ?string $author,
        public readonly ?DateTimeInterface $publishAt
    ) {}

    public static function fromEntity(Book $book): self{
        return new self(
            $book->getId(),
            $book->getTitle(),
            $book->getAuthor(),
            $book->getPublishAt()
        );
    }
}