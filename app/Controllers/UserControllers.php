<?php


namespace App\Controllers;


use App\Database;
use Tests\User;
use App\Redirect;
use App\Services\Users\Register\UserRegisterRequest;
use App\Services\Users\Register\UserRegisterService;
use App\Services\Users\SearchUser\SearchUserRequest;
use App\Services\Users\SearchUser\SearchUserService;
use App\Services\Users\SignIn\SignInUserRequest;
use App\Services\Users\SignIn\SignInUserResponse;
use App\Services\Users\SignIn\SignInUserService;
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
        $registered = (new SearchUserService())
            ->execute(new SearchUserRequest($_POST["email"]));

        if (!$registered) {
            return new Redirect('/users/message');
        } else {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

            (new UserRegisterService())
                ->execute(new UserRegisterRequest(
                    $_POST['name'],
                    $_POST['surname'],
                    $_POST['email'],
                    $hashedPassword
                ));
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
        $registered = (new SearchUserService())
            ->execute(new SearchUserRequest($_POST["email"]));

        if ($registered) {

            $checkPassword = password_verify($_POST['password'], $registered['password']);

            if ($checkPassword == false) {
                return new Redirect('/users/message');
            }

            $user = (new SignInUserService())
                ->execute(new SignInUserRequest($_POST["email"]));

            SessionControllers::setUser(
                $user->getId(),
                $user->getName(),
                $user->getSurname()
            );

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

