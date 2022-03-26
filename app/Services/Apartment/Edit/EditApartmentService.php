<?php

namespace App\Services\Apartment\Edit;

use Tests\Apartment;
use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class EditApartmentService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(EditApartmentRequest $request): Apartment
    {
        $apartmentId = $request->getApartmentId();

        $response = $this->apartmentsRepository->getById($apartmentId);

        return (new EditApartmentResponse($response))->getApartment();
    }
}

