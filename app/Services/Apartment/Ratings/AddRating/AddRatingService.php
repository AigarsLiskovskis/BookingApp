<?php

namespace App\Services\Apartment\Ratings\AddRating;

use App\Repositories\Ratings\PDORatingsRepository;
use App\Repositories\Ratings\RatingsRepository;
use Doctrine\DBAL\Exception;

class AddRatingService
{
    private RatingsRepository $ratingsRepository;

    public function __construct()
    {
        $this->ratingsRepository = new PDORatingsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(AddRatingRequest $request)
    {
        $apartmentId = $request->getApartmentId();
        $userId = $request->getUserId();
        $rating = $request->getRating();

        $this->ratingsRepository->setRating($apartmentId, $userId, $rating);
    }

}