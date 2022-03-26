<?php

namespace App\Services\Apartment\Show;

use Tests\Apartment;
use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class ShowApartmentService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(ShowApartmentRequest $request): Apartment
    {
        $apartmentId = $request->getApartmentId();

        $response = $this->apartmentsRepository->getById($apartmentId);

        return (new ShowApartmentResponse($response))->getApartment();
    }
}
