<?php

namespace App\Services\Apartment\Ratings\ApartmentRating;

use App\Repositories\Ratings\PDORatingsRepository;
use App\Repositories\Ratings\RatingsRepository;
use Doctrine\DBAL\Exception;

class ApartmentsRatingService
{
    private RatingsRepository $ratingsRepository;

    public function __construct()
    {
        $this->ratingsRepository = new PDORatingsRepository();
    }


    /**
     * @throws Exception
     */
    public function execute(ApartmentRatingRequest $request): int
    {
        $apartmentId = $request->getApartmentId();

        $response = $this->ratingsRepository->getRating($apartmentId);

        return (new ApartmentRatingResponse($response))->getRating();
    }

}