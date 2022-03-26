<?php

namespace App\Services\Apartment\Update;

class UpdateApartmentRequest
{
    private string $name;
    private string $address;
    private string $description;
    private int $userId;
    private int $price;
    private string $availableFrom;
    private string $availableTill;
    private int $apartmentId;

    public function __construct(string $name,
                                string $address,
                                string $description,
                                int    $userId,
                                int    $price,
                                string $availableFrom,
                                string $availableTill,
                                int $apartmentId)
    {
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->userId = $userId;
        $this->price = $price;
        $this->availableFrom = $availableFrom;
        $this->availableTill = $availableTill;
        $this->apartmentId = $apartmentId;
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
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
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

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }
}