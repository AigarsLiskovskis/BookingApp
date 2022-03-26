<?php

namespace App\Repositories\Users;

use Tests\User;

interface UserRepository
{
    public function getName(int $userId): string;

    public function searchUser(string $email);

    public function registerUser(string $name, string $surname, string $email, string $password): void;

    public function getUser(string $email): User;

}