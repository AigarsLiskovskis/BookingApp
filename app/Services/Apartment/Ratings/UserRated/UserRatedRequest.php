<?php

namespace App\Services\Apartment\Ratings\UserRated;

class UserRatedRequest
{
    private int $apartmentId;
    private int $userId;

    public function __construct(int $apartmentId, int $userId)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
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

}