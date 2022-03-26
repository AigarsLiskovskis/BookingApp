<?php

namespace App\Services\Users\Register;

use App\Repositories\Users\PDOUserRepository;
use App\Repositories\Users\UserRepository;
use Doctrine\DBAL\Exception;

class UserRegisterService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new PDOUserRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(UserRegisterRequest $request)
    {
        $name = $request->getName();
        $surname = $request->getSurname();
        $email = $request->getEmail();
        $password =$request->getPassword();

        $this->userRepository->registerUser($name, $surname, $email, $password);
    }

}

