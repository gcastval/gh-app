<?php


namespace App\Service\Book;

use App\Command\Book\BookCreateCommand;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class BookCreator
{

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function create(BookCreateCommand $command): int
    {        
        $book = (new Book())
            ->setTitle($command->title)
            ->setAuthor($command->author)
            ->setPrice($command->price)
            ->setPages($command->pages)
            ->setIsbn($command->isbn)
            ->setPublisher($command->publisher)
            ->setPublishedAt(new \DateTime($command->published_at));

        $this->em->persist($book);
        $this->em->flush();

        return $book->getId();

    }
}