<?php

namespace App\Services\Reviews\Add;

use App\Repositories\Reviews\PDOReviewsRepository;
use App\Repositories\Reviews\ReviewsRepository;
use Doctrine\DBAL\Exception;

class AddReviewService
{
    private ReviewsRepository $reviewsRepository;

    public function __construct()
    {
        $this->reviewsRepository = new PDOReviewsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(AddReviewRequest $request): void
    {
        $apartmentId = $request->getApartmentId();
        $review = $request->getReview();
        $createdBy = $request->getCreatedBy();
        $userId = $request->getUserId();

        $this->reviewsRepository->addReviews($apartmentId, $review, $createdBy, $userId);
    }
}