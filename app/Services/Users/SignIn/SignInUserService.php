<?php

namespace App\Services\Users\SignIn;

use Tests\User;
use App\Repositories\Users\PDOUserRepository;
use App\Repositories\Users\UserRepository;
use Doctrine\DBAL\Exception;

class SignInUserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new PDOUserRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(SignInUserRequest $request): User
    {
        $email = $request->getEmail();

        $response = $this->userRepository->getUser($email);

        return (new SignInUserResponse($response))->getUser();

    }


}