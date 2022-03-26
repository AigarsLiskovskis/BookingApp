<?php

namespace App\Services\Apartment\CountMoney;

use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class GetPriceService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(GetPriceRequest $request): int
    {
        $apartmentId = $request->getApartmentId();

        $response = $this->apartmentsRepository->getPrice($apartmentId);

        return (new GetPriceResponse($response))->getPrice();
    }


}