<?php

namespace App\Services\Apartment\Ratings\ApartmentRating;

class ApartmentRatingResponse
{

    private $rating;

    public function __construct($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }
}