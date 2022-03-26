<?php

namespace App\Repositories\Users;

use App\Database;
use Tests\User;
use Doctrine\DBAL\Exception;

class PDOUserRepository implements UserRepository
{

    /**
     * @throws Exception
     */
    public function getName(int $userId): string
    {
        $ownerQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id =?')
            ->setParameter(0, $userId)
            ->executeQuery()
            ->fetchAssociative();

        return $ownerQuery['name'] . ' ' . $ownerQuery['surname'];
    }

    /**
     * @throws Exception
     */
    public function searchUser(string $email)
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('email =?')
            ->setParameter(0, $email)
            ->executeQuery()
            ->fetchAssociative();
    }

    /**
     * @throws Exception
     */
    public function registerUser(string $name, string $surname, string $email, string $password): void
    {
        Database::connection()
            ->insert('users',
                [
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $email,
                    'password' => $password
                ]);
    }

    /**
     * @throws Exception
     */
    public function getUser(string $email): User
    {
        $userQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('email =?')
            ->setParameter(0, $email)
            ->executeQuery()
            ->fetchAssociative();

        return new User(
            $userQuery['id'],
            $userQuery['name'],
            $userQuery['surname'],
            $userQuery['password'],
            $userQuery['email'],
            $userQuery['created_at'],
        );
    }
}