<?php

namespace App\Services\Users\SearchUser;

class SearchUserRequest
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}
