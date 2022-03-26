<?php

namespace App\Services\Apartment\Index;


use App\Repositories\Apartments\ApartmentsRepository;
use App\Repositories\Apartments\PDOApartmentRepository;
use Doctrine\DBAL\Exception;

class IndexApartmentService
{
    private ApartmentsRepository $apartmentsRepository;

    public function __construct()
    {
        $this->apartmentsRepository = new PDOApartmentRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(): array
    {
        $response = $this->apartmentsRepository->getAll();

        return (new IndexApartmentResponse($response))->getApartments();
    }
}

