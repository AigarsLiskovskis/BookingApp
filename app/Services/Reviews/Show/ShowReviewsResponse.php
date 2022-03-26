<?php

namespace App\Services\Reviews\Show;

class ShowReviewsResponse
{
    private array $reviews;

    public function __construct(array $reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * @return array
     */
    public function getReviews(): array
    {
        return $this->reviews;
    }

}
