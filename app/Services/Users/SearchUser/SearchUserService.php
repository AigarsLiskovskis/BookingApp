<?php

namespace App\Services\Users\SearchUser;

use App\Repositories\Users\PDOUserRepository;
use App\Repositories\Users\UserRepository;
use Doctrine\DBAL\Exception;

class SearchUserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new PDOUserRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(SearchUserRequest $request)
    {
        $email = $request->getEmail();

        return $this->userRepository->searchUser($email);
    }
}