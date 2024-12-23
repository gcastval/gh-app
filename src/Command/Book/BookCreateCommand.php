<?php

declare(strict_types=1);

namespace App\Command\Book;

final class BookCreateCommand
{
    public function __construct(
        public readonly string $title,
        public readonly string $author,
        public readonly int $price,
        public readonly int $pages,
        public readonly string $isbn,
        public readonly string $publisher,
        public readonly string $published_at,
    ) {
    }
}
