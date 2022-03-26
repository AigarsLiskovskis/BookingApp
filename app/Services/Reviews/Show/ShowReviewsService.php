<?php

namespace App\Services\Reviews\Show;

use App\Repositories\Reviews\PDOReviewsRepository;
use App\Repositories\Reviews\ReviewsRepository;
use Doctrine\DBAL\Exception;

class ShowReviewsService
{
    private ReviewsRepository $reviewsRepository;

    public function __construct()
    {
        $this->reviewsRepository = new PDOReviewsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(ShowReviewsRequest $request): array
    {
        $apartmentId = $request->getApartmentId();

        $response = $this->reviewsRepository->getReviews($apartmentId);

        return (new ShowReviewsResponse($response))->getReviews();
    }

}