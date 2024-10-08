<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\User;
use App\Entity\UserBook;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\PublisherRepository;
use App\Repository\UserBookRepository;

class ProfileService
{
    public function __construct(
        private readonly GoogleBooksApiService $googleBooksApiService,
        private readonly BookRepository $bookRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PublisherRepository $publisherRepository,
        private readonly UserBookRepository $userBookRepository
    ) {}

    public function addBookToProfile(User $user, string $id): UserBook
    {
        $book = $this->getOrCreateBook($id);

        $userBook = $this->userBookRepository->findOneBy([
            'reader' => $user,
            'book' => $book,
        ]);

        if (!$userBook) {
            $userBook = new UserBook();

            $userBook
                ->setReader($user)
                ->setBook($book)
                ->setCreatedAt(new \DateTimeImmutable())
            ;

            $this->userBookRepository->save($userBook, true);
        }

        return $userBook;
    }

    private function getOrCreateBook(string $id): Book
    {
        $bookFromGoogle = $this->googleBooksApiService->get($id);

        $book = $this->bookRepository->findOneBy([
            'googleBooksId' => $id,
        ]);

        if (!$book) {
            $book = new Book();

            $book
                ->setTitle($bookFromGoogle['volumeInfo']['title'] ?? null)
                ->setSubtitle($bookFromGoogle['volumeInfo']['subtitle'] ?? null)
                ->setDescription($bookFromGoogle['volumeInfo']['description'] ?? null)
                ->setGoogleBooksId($id)
                ->setIsbn10($bookFromGoogle['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? null)
                ->setIsbn13($bookFromGoogle['volumeInfo']['industryIdentifiers'][1]['identifier'] ?? null)
                ->setPageCount($bookFromGoogle['volumeInfo']['pageCount'] ?? null)
                ->setPublishDate(new \DateTimeImmutable($bookFromGoogle['volumeInfo']['publishedDate'] ?? null))
                ->setSmallThumbnail($bookFromGoogle['volumeInfo']['imageLinks']['smallThumbnail'] ?? null)
                ->setThumbnail($bookFromGoogle['volumeInfo']['imageLinks']['thumbnail'] ?? null)
            ;

            foreach ($bookFromGoogle['volumeInfo']['authors'] ?? [] as $authorName) {
                $author = $this->getOrCreateAuthor($authorName);

                $book->addAuthor($author);
            }

            $publisher = $this->getOrCreatePublisher($bookFromGoogle['volumeInfo']['publisher'] ?? null);
            $book->addPublisher($publisher);

            $this->bookRepository->save($book, true);
        }

        return $book;
    }

    private function getOrCreateAuthor(string $name): Author
    {
        $author = $this->authorRepository->findOneBy([
            'name' => $name,
        ]);

        if (!$author) {
            $author = new Author();

            $author->setName($name);

            $this->authorRepository->save($author, true);
        }

        return $author;
    }

    private function getOrCreatePublisher(string $name): Publisher
    {
        $publisher = $this->publisherRepository->findOneBy([
            'name' => $name,
        ]);

        if (!$publisher) {
            $publisher = new Publisher();

            $publisher->setName($name);

            $this->publisherRepository->save($publisher, true);
        }

        return $publisher;
    }
}