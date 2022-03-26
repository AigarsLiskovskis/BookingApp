<?php

namespace App\Services\Users\Names;

class UserNamesResponse
{
    private string $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

}