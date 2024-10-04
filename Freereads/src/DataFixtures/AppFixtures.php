<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use DatetimeImutable;
use App\Entity\Author;
use App\Entity\Status;
use App\Entity\UserBook;
use App\Entity\Publisher;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Creation de 10 Authors
        $authors = [];
        for ($i = 0; $i < 10; $i++) {
            $author = new Author();
            $author->setName($faker->Name);
            $manager->persist($author);
            $authors[] = $author;
        }

        // create 10 Publishers
        $publishers = [];
        for ($i = 0; $i < 10; $i++) {
            $publisher = new Publisher();
            $publisher->setName($faker->Name);
            $manager->persist($publisher);
            $publishers[] = $publisher;
        }

        // Create Status
        $status = [];
        foreach (['to-read', 'reading', 'read'] as $value) {
            $oneStatus = new Status();
            $oneStatus->setName($value);
            $manager->persist($oneStatus);
            $status[] = $oneStatus;
        }

        // Create 100 Books
        $books = [];
        for ($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book
                ->setGoogleBooksId($faker->uuid)
                ->setTitle($faker->sentence(3))
                ->setSubtitle($faker->sentence)
                ->setPublishDate($faker->dateTime)
                ->setDescription($faker->text)
                ->setIsbn10($faker->isbn10)
                ->setIsbn13($faker->isbn13)
                ->setPageCount($faker->numberBetween(10, 1000))
                ->setThumbnail($faker->imageUrl(200, 300))
                ->setSmallThumbnail($faker->imageUrl(100, 150))
                ->addAuthor($faker->randomElement($authors))
                ->addPublisher($faker->randomElement($publishers))
            ;

            $manager->persist($book);
            $books[] = $book;
        }

        // Create 10 Users
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setPseudo($faker->username)
            ;
            $manager->persist($user);
            $users[] = $user;
        }

        // Create 10 UserBook by User
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                $userBook = new UserBook();
                $userBook
                ->setReader($user)
                ->setStatus($faker->randomElement($status))
                ->setRating($faker->numberBetween(0, 5))
                ->setComment($faker->text)
                ->setBook($faker->randomElement($books))
                ->setCreatedAt(\DatetimeImmutable::createFromMutable($faker->dateTime))
                ->setUpdatedAt(\DatetimeImmutable::createFromMutable($faker->dateTime))
                ;
                $manager->persist($userBook);
            }
        }



        $manager->flush();
    }
}
