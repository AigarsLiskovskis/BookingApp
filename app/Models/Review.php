<?php

namespace App\Models;

class Review
{
    private int $id;
    private int $apartmentId;
    private string $review;
    private string $createdBy;
    private int $userId;
    private string $createdAt;

    public function __construct(int $id,
                                int $apartmentId,
                                string $review,
                                string $createdBy,
                                int $userId,
                                string $createdAt)
    {
        $this->id = $id;
        $this->apartmentId = $apartmentId;
        $this->review = $review;
        $this->createdBy = $createdBy;
        $this->userId = $userId;
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
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }

    /**
     * @return string
     */
    public function getReview(): string
    {
        return $this->review;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
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
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

}
