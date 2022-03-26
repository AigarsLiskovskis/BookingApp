<?php

namespace Tests;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetName()
    {
        $user = new User(11, 'John', 'Doe', 'test@mail.com', 'yesterday');
        $this->assertSame('John', $user->getName());
    }

    public function testGetId()
    {
        $user = new User(11, 'John', 'Doe', 'test@mail.com', 'yesterday');
        $this->assertSame(11, $user->getId());
    }

    public function testGetEmail()
    {
        $user = new User(11, 'John', 'Doe', 'test@mail.com', 'yesterday');
        $this->assertSame('test@mail.com', $user->getEmail());
    }

    public function testGetSurname()
    {
        $user = new User(11, 'John', 'Doe', 'test@mail.com', 'yesterday');
        $this->assertSame('Doe', $user->getSurname());
    }

    public function testGetCreatedAt()
    {
        $user = new User(11, 'John', 'Doe', 'test@mail.com', 'yesterday');
        $this->assertSame('yesterday', $user->getCreatedAt());
    }
}
