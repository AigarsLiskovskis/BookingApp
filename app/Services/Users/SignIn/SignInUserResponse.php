<?php

namespace App\Services\Users\SignIn;

use Tests\User;

class SignInUserResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}