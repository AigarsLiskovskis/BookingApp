<?php

namespace App\Services\Apartment\Ratings\UserRated;

use App\Repositories\Ratings\PDORatingsRepository;
use App\Repositories\Ratings\RatingsRepository;
use Doctrine\DBAL\Exception;


class UserRatedService
{
    private RatingsRepository $ratingsRepository;

    public function __construct()
    {
        $this->ratingsRepository = new PDORatingsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(UserRatedRequest $request):bool
    {
        $apartmentId = $request->getApartmentId();
        $userId = $request->getUserId();

        return $this->ratingsRepository->userRated($apartmentId, $userId);
    }

}
