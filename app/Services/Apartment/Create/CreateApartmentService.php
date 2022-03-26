<?php

namespace App\Services\Apartment\Create;

use Tests\Apartment;
use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class CreateApartmentService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(CreateApartmentRequest $request): void
    {
        $apartment = new Apartment(
            $request->getName(),
            $request->getAddress(),
            $request->getDescription(),
            $request->getUserId(),
            $request->getPrice(),
            $request->getAvailableFrom(),
            $request->getAvailableTill(),
        );

        $this->apartmentsRepository->create($apartment);
    }

}