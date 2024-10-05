<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Publisher;
use App\Entity\UserBook;

class BookTest extends TestCase
{
    private Book $book;

    protected function setUp(): void
    {
        $this->book = new Book();
    }

    public function testGetterAndSetterForGoogleBooksId(): void
    {
        $googleBooksId = 'abc123';
        $this->book->setGoogleBooksId($googleBooksId);
        $this->assertEquals($googleBooksId, $this->book->getGoogleBooksId());
    }

    public function testGetterAndSetterForTitle(): void
    {
        $title = 'Test Book Title';
        $this->book->setTitle($title);
        $this->assertEquals($title, $this->book->getTitle());
    }

    public function testGetterAndSetterForSubtitle(): void
    {
        $subtitle = 'Test Book Subtitle';
        $this->book->setSubtitle($subtitle);
        $this->assertEquals($subtitle, $this->book->getSubtitle());
    }

    public function testGetterAndSetterForPublishDate(): void
    {
        $publishDate = new \DateTime('2023-01-01');
        $this->book->setPublishDate($publishDate);
        $this->assertEquals($publishDate, $this->book->getPublishDate());
    }

    public function testGetterAndSetterForDescription(): void
    {
        $description = 'This is a test book description.';
        $this->book->setDescription($description);
        $this->assertEquals($description, $this->book->getDescription());
    }

    public function testGetterAndSetterForIsbn10(): void
    {
        $isbn10 = '1234567890';
        $this->book->setIsbn10($isbn10);
        $this->assertEquals($isbn10, $this->book->getIsbn10());
    }

    public function testGetterAndSetterForIsbn13(): void
    {
        $isbn13 = '1234567890123';
        $this->book->setIsbn13($isbn13);
        $this->assertEquals($isbn13, $this->book->getIsbn13());
    }

    public function testGetterAndSetterForPageCount(): void
    {
        $pageCount = 200;
        $this->book->setPageCount($pageCount);
        $this->assertEquals($pageCount, $this->book->getPageCount());
    }

    public function testGetterAndSetterForSmallThumbnail(): void
    {
        $smallThumbnail = 'http://example.com/small-thumbnail.jpg';
        $this->book->setSmallThumbnail($smallThumbnail);
        $this->assertEquals($smallThumbnail, $this->book->getSmallThumbnail());
    }

    public function testGetterAndSetterForThumbnail(): void
    {
        $thumbnail = 'http://example.com/thumbnail.jpg';
        $this->book->setThumbnail($thumbnail);
        $this->assertEquals($thumbnail, $this->book->getThumbnail());
    }

    public function testAddAndRemoveAuthor(): void
    {
        $author = new Author();
        $this->book->addAuthor($author);
        $this->assertCount(1, $this->book->getAuthors());
        $this->assertTrue($this->book->getAuthors()->contains($author));

        $this->book->removeAuthor($author);
        $this->assertCount(0, $this->book->getAuthors());
        $this->assertFalse($this->book->getAuthors()->contains($author));
    }

    public function testAddAndRemovePublisher(): void
    {
        $publisher = new Publisher();
        $this->book->addPublisher($publisher);
        $this->assertCount(1, $this->book->getPublishers());
        $this->assertTrue($this->book->getPublishers()->contains($publisher));

        $this->book->removePublisher($publisher);
        $this->assertCount(0, $this->book->getPublishers());
        $this->assertFalse($this->book->getPublishers()->contains($publisher));
    }

    public function testAddAndRemoveUserBook(): void
    {
        $userBook = new UserBook();
        $this->book->addUserBook($userBook);
        $this->assertCount(1, $this->book->getUserBooks());
        $this->assertTrue($this->book->getUserBooks()->contains($userBook));
        $this->assertSame($this->book, $userBook->getBook());

        $this->book->removeUserBook($userBook);
        $this->assertCount(0, $this->book->getUserBooks());
        $this->assertFalse($this->book->getUserBooks()->contains($userBook));
        $this->assertNull($userBook->getBook());
    }
}
