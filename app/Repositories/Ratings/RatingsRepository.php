<?php

namespace App\Repositories\Ratings;

interface RatingsRepository
{
    public function getRating(int $apartmentId): int;

    public function userRated(int $apartmentId, int $userid):bool;

    public function setRating(int $apartmentId, int $userId, int $rating): void;

}