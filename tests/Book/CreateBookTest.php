<?php

declare(strict_types=1);

namespace App\Tests\Book;

use App\Entity\Book;
use App\Tests\Shared\AbstractTestCase;

class CreateBookTest extends AbstractTestCase
{

    public function testBookCanBeCreated()
    {
        $this->client->request('POST', '/api/v1/book', [
            'title' => 'El libro de la vida',
            'author' => 'Juan Perez',
            'price' => 100,
            'pages' => 260,
            'isbn' => '1234567890',
            'publisher' => 'La casa del libro',
            'published_at' => '2024-12-20',
        ]);
        
        
        $body = json_decode($this->client->getResponse()->getContent(), true);
        $statusCode = $this->client->getResponse()->getStatusCode();

        $id = $body['id'];

        $this->assertSame(200, $statusCode);
        $this->assertIsNumeric($id);

        $book = $this->entityManager->getRepository(Book::class)->find($id);

        $this->assertNotNull($book, 'Book not found in db');
        $this->assertSame('El libro de la vida', $book->getTitle());
    }
}