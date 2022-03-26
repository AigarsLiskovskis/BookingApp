<?php

namespace App\Services\Users\Names;

use App\Repositories\Users\PDOUserRepository;
use App\Repositories\Users\UserRepository;
use Doctrine\DBAL\Exception;

class UserNamesService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new PDOUserRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(UserNamesRequest $request): string
    {
        $userId = $request->getUserId();

        $response = $this->userRepository->getName($userId);

        return (new UserNamesResponse($response))->getUserName();

    }

}