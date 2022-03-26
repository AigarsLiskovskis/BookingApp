<?php

namespace App\Services\Reviews\Add;

class AddReviewRequest
{
    private int $apartmentId;
    private string $review;
    private string $createdBy;
    private int $userId;

    public function __construct(int $apartmentId, string $review, string $createdBy, int $userId)
    {
        $this->apartmentId = $apartmentId;
        $this->review = $review;
        $this->createdBy = $createdBy;
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

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getReview(): string
    {
        return $this->review;
    }

}

