<?php

namespace App\Models;


class Apartment
{
    private int $id;
    private string $name;
    private string $address;
    private string $description;
    private int $userId;
    private string $availableFrom;
    private string $availableTill;

    public function __construct(int $id, string $name, string $address, string $description, int $userId, string $availableFrom, string $availableTill)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->userId = $userId;
        $this->availableFrom = $availableFrom;
        $this->availableTill = $availableTill;
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
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getAvailableFrom(): string
    {
        return $this->availableFrom;
    }

    /**
     * @return string
     */
    public function getAvailableTill(): string
    {
        return $this->availableTill;
    }

}