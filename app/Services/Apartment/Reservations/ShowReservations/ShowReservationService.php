<?php

namespace App\Services\Apartment\Reservations\ShowReservations;

use App\Repositories\Reservations\PDOReservationsRepository;
use App\Repositories\Reservations\ReservationsRepository;
use Doctrine\DBAL\Exception;

class ShowReservationService
{
    private ReservationsRepository $reservationsRepository;

    public function __construct()
    {
        $this->reservationsRepository = new PDOReservationsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(ShowReservationRequest $request): array
    {
        $apartmentId = $request->getApartmentId();

        $response = $this->reservationsRepository->getReservations($apartmentId);

        return (new ShowReservationsResponse($response))->getReservations();

    }

}