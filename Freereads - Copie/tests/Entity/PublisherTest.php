<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Publisher;
use App\Entity\Book;

class PublisherTest extends TestCase
{
    public function testConstructor()
    {
        $publisher = new Publisher();
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $publisher->getBooks());
        $this->assertCount(0, $publisher->getBooks());
    }

    public function testAddBook()
    {
        $publisher = new Publisher();
        $book = new Book();

        $result = $publisher->addBook($book);

        $this->assertSame($publisher, $result);
        $this->assertCount(1, $publisher->getBooks());
        $this->assertTrue($publisher->getBooks()->contains($book));
    }

    public function testAddBookTwice()
    {
        $publisher = new Publisher();
        $book = new Book();

        $publisher->addBook($book);
        $result = $publisher->addBook($book);

        $this->assertSame($publisher, $result);
        $this->assertCount(1, $publisher->getBooks());
    }

    public function testRemoveBook()
    {
        $publisher = new Publisher();
        $book = new Book();
        $publisher->addBook($book);

        $result = $publisher->removeBook($book);

        $this->assertSame($publisher, $result);
        $this->assertCount(0, $publisher->getBooks());
        $this->assertFalse($publisher->getBooks()->contains($book));
    }

    public function testRemoveNonExistentBook()
    {
        $publisher = new Publisher();
        $book = new Book();

        $result = $publisher->removeBook($book);

        $this->assertSame($publisher, $result);
        $this->assertCount(0, $publisher->getBooks());
    }

    public function testGetBooks()
    {
        $publisher = new Publisher();
        $book1 = new Book();
        $book2 = new Book();

        $publisher->addBook($book1);
        $publisher->addBook($book2);

        $books = $publisher->getBooks();

        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $books);
        $this->assertCount(2, $books);
        $this->assertTrue($books->contains($book1));
        $this->assertTrue($books->contains($book2));
    }
}

