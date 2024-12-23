<?php

declare(strict_types=1);

namespace App\Controller\Book;

use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Book\BookCreator;
use App\Command\Book\BookCreateCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api/v1/book', name: 'book')]
class BookController extends AbstractController
{
    public function __construct(
        private readonly BookCreator $service,
    ) {
    }

    #[Route(name: 'create_book', methods: ['POST'])]
    public function _create(#[MapRequestPayload] BookCreateCommand $book): JsonResponse
    {

        $id = $this->service->create($book);

        return new JsonResponse([
            'id' => $id,
        ]);
    }

    #[Route(name: 'list_books', methods: ['GET'])]
    public function _get(int $id): JsonResponse
    {
        $books = $this->service->getAll($id);

        return new JsonResponse($books, Response::HTTP_OK);
    }
}
