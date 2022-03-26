<?php

namespace App\Services\Apartment\Delete;


class DeleteApartmentRequest
{
    private int $apartmentId;

    public function __construct(int $apartmentId)
    {
        $this->apartmentId = $apartmentId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->apartmentId;
    }
}

