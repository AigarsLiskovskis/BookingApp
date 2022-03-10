<?php

namespace App\Controllers;

use App\Database;
use App\Models\Review;
use App\Redirect;
use Doctrine\DBAL\Exception;

class ReviewControllers
{
    /**
     * @throws Exception
     */
    public function showReviews($apartmentId): array
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
    public function addReview(array $input): Redirect
    {
        var_dump('hello');
        Database::connection()
            ->insert('reviews',
                [
                    'apartment_id' => (int)$input['id'],
                    'review' => $_POST['review'],
                    'created_by' => $_SESSION["name"] . " " . $_SESSION["surname"],
                    'user_id' => $_SESSION["userid"],
                ]);
        return new Redirect('/apartments/' . $input['id']);
    }


    /**
     * @throws Exception
     */
    public function deleteReview(array $input): Redirect
    {
        Database::connection()
            ->delete('reviews', ['id' => (int)$input['id']]);
        return new Redirect('/apartments/' . $_SESSION['apartmentId']);
    }

}