<?php

namespace App\Repositories\Reviews;

use App\Database;
use Tests\Review;
use Doctrine\DBAL\Exception;

class PDOReviewsRepository implements ReviewsRepository
{

    /**
     * @throws Exception
     */
    public function getReviews(int $apartmentId): array
    {
        $reviewQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reviews')
            ->where('apartment_id =?')
            ->setParameter(0, $apartmentId)
            ->orderBy('created_at', 'desc')
            ->executeQuery()
            ->fetchAllAssociative();

        $reviews = [];
        foreach ($reviewQuery as $item) {
            $reviews[] = new Review(
                $item['id'],
                $item['apartment_id'],
                $item['review'],
                $item['created_by'],
                $item['user_id'],
                $item['created_at']
            );
        }
        return $reviews;
    }

    /**
     * @throws Exception
     */
    public function addReviews(int $apartmentId, string $review, string $createdBy, int $userId): void
    {
        Database::connection()
            ->insert('reviews',
                [
                    'apartment_id' => $apartmentId,
                    'review' => $review,
                    'created_by' => $createdBy,
                    'user_id' => $userId,
                ]);
    }

    /**
     * @throws Exception
     */
    public function deleteReview(int $id): void
    {
        Database::connection()
            ->delete('reviews', ['id' => $id]);
    }
}