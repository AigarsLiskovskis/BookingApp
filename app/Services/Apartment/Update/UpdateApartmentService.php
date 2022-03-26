<?php

namespace App\Services\Apartment\Update;

use Tests\Apartment;
use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class UpdateApartmentService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }


    /**
     * @throws Exception
     */
    public function execute(UpdateApartmentRequest $request): void
    {
        $apartment = new Apartment(
            $request->getName(),
            $request->getAddress(),
            $request->getDescription(),
            $request->getUserId(),
            $request->getPrice(),
            $request->getAvailableFrom(),
            $request->getAvailableTill(),
            $request->getApartmentId()
        );

        $this->apartmentsRepository->update($apartment);
    }


}