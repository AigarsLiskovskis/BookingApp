<?php

namespace App\Repositories\Reviews;

interface ReviewsRepository
{
    public function getReviews(int $apartmentId): array;

    public function addReviews(int $apartmentId, string $review, string $createdBy, int $userId): void;

    public function deleteReview(int $id): void;
}