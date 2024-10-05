<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserBook;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetId(): void
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testEmailGetterAndSetter(): void
    {
        $user = new User();
        $email = 'test@example.com';

        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
    }

    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $email = 'test@example.com';

        $user->setEmail($email);
        $this->assertEquals($email, $user->getUserIdentifier());
    }

    public function testRolesGetterAndSetter(): void
    {
        $user = new User();
        $roles = ['ROLE_ADMIN'];

        $user->setRoles($roles);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testPasswordGetterAndSetter(): void
    {
        $user = new User();
        $password = 'password123';

        $user->setPassword($password);
        $this->assertEquals($password, $user->getPassword());
    }

    public function testPseudoGetterAndSetter(): void
    {
        $user = new User();
        $pseudo = 'johndoe';

        $user->setPseudo($pseudo);
        $this->assertEquals($pseudo, $user->getPseudo());
    }

    public function testAddAndRemoveUserBook(): void
    {
        $user = new User();
        $userBook = new UserBook();

        $user->addUserBook($userBook);
        $this->assertCount(1, $user->getUserBooks());
        $this->assertTrue($user->getUserBooks()->contains($userBook));

        $user->removeUserBook($userBook);
        $this->assertCount(0, $user->getUserBooks());
        $this->assertFalse($user->getUserBooks()->contains($userBook));
    }

    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->eraseCredentials();
        $this->assertNull($user->getPassword());
    }
}
