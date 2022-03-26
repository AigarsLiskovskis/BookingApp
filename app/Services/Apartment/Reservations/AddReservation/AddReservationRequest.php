<?php

namespace App\Services\Apartment\Reservations\AddReservation;

class AddReservationRequest
{
    private int $apartmentId;
    private int $userId;
    private string $reservedFrom;
    private string $reservedTill;

    public function __construct(int $apartmentId, int $userId, string $reservedFrom, string $reservedTill)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->reservedFrom = $reservedFrom;
        $this->reservedTill = $reservedTill;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
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
    public function getReservedFrom(): string
    {
        return $this->reservedFrom;
    }

    /**
     * @return string
     */
    public function getReservedTill(): string
    {
        return $this->reservedTill;
    }


}