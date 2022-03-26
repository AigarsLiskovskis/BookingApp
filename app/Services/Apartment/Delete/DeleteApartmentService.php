<?php

namespace App\Services\Apartment\Delete;

use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class DeleteApartmentService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }


    /**
     * @throws Exception
     */
    public function execute(DeleteApartmentRequest $request)
    {
        $apartmentId = $request->getId();

        $this->apartmentsRepository->delete($apartmentId);
    }
}

