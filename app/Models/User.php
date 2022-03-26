<?php

namespace App\Models;

class User
{
    private int $id;
    private string $name;
    private string $surname;
    private ?string $email;
    private ?string $createdAt;

    public function __construct(int    $id,
                                string $name,
                                string $surname,
                                ?string $email = null,
                                ?string $createdAt = null)
    {

        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

}

