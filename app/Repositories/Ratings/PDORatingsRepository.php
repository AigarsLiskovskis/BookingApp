<?php

namespace App\Repositories\Ratings;

use App\Database;
use Doctrine\DBAL\Exception;

class PDORatingsRepository implements RatingsRepository
{

    /**
     * @throws Exception
     */
    public function getRating(int $apartmentId): int
    {
        $ratingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('avg(rating)')
            ->from('ratings')
            ->where('apartment_id =?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAssociative();

        return round($ratingQuery['avg(rating)']) ?? 0;
    }


    /**
     * @throws Exception
     */
    public function userRated(int $apartmentId, int $userid):bool
    {
        $ratedQuery = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('ratings')
            ->where("apartment_id = $apartmentId")
            ->andWhere("user_id = $userid")
            ->executeQuery()
            ->fetchAssociative();

        return !$ratedQuery;
    }


    /**
     * @throws Exception
     */
    public function setRating(int $apartmentId, int $userId, int $rating): void
    {
        Database::connection()
            ->insert('ratings',
                [
                    'apartment_id' => $apartmentId,
                    'user_id' => $userId,
                    'rating' => $rating
                ]);
    }
}
