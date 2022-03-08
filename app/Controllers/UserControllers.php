<?php


namespace App\Controllers;


use App\Database;
use App\Models\User;
use App\Redirect;
use App\Views\View;
use Doctrine\DBAL\Exception;

class UserControllers
{
    public function signUp(): View
    {
        return new View('Users/signUp');
    }

    /**
     * @throws Exception
     */
    public function register(): Redirect
    {
        $userQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('email =?')
            ->setParameter(0, $_POST["email"])
            ->executeQuery()
            ->fetchAssociative();

        if ($userQuery) {
            return new Redirect('/users/message');
        } else {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
            Database::connection()
                ->insert('users',
                    [
                        'name' => $_POST['name'],
                        'surname' => $_POST['surname'],
                        'email' => $_POST['email'],
                        'password' => $hashedPassword
                    ]);
            return new Redirect('/users');
        }
    }

    public function login(): View
    {
        return new View('Users/login');
    }

    /**
     * @throws Exception
     */
    public function signIn(): Redirect
    {
        $userQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('email =?')
            ->setParameter(0, $_POST["email"])
            ->executeQuery()
            ->fetchAssociative();

        if ($userQuery) {
            $checkPassword = password_verify($_POST['password'], $userQuery['password']);

            if ($checkPassword == false) {
                return new Redirect('/users/message');
            }

            $user = new User(
                $userQuery['id'],
                $userQuery['name'],
                $userQuery['surname'],
                $userQuery['email'],
                $userQuery['created_at'],
            );

            SessionControllers::setUser($user->getId(), $user->getName(), $user->getSurname());

            return new Redirect('/');
        } else {
            return new Redirect('/users/message');
        }
    }

    public function error(): View
    {
        return new View('Users/message');
    }

    public function logout(): Redirect
    {
        unset($_SESSION['userid']);
        return new Redirect('/');
    }
}

