<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\Reviews\Add\AddReviewRequest;
use App\Services\Reviews\Add\AddReviewService;
use App\Services\Reviews\Delete\DeleteReviewRequest;
use App\Services\Reviews\Delete\DeleteReviewsService;
use App\Services\Reviews\Show\ShowReviewsRequest;
use App\Services\Reviews\Show\ShowReviewsService;
use Doctrine\DBAL\Exception;

class ReviewControllers
{
    /**
     * @throws Exception
     */
    public function showReviews($apartmentId): array
    {
        return (new ShowReviewsService())
            ->execute(new ShowReviewsRequest($apartmentId));
    }

    /**
     * @throws Exception
     */
    public function addReview(array $input): Redirect
    {
        (new AddReviewService())
            ->execute(new AddReviewRequest(
                (int)$input['id'],
                $_POST['review'],
                $_SESSION["name"] . " " . $_SESSION["surname"],
                $_SESSION["userid"]
            ));
        return new Redirect('/apartments/' . $input['id']);
    }


    /**
     * @throws Exception
     */
    public function deleteReview(array $input): Redirect
    {
        (new DeleteReviewsService())
            ->execute(new DeleteReviewRequest(
                (int)$input['id']
            ));

        return new Redirect('/apartments/' . $_SESSION['apartmentId']);
    }

}