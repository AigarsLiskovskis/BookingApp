<?php

namespace App\Services\Apartment\Ratings\AddRating;

class AddRatingRequest
{
    private int $apartmentId;
    private int $userId;
    private int $rating;

    public function __construct(int $apartmentId, int $userId, int $rating)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->rating = $rating;
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
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

}
