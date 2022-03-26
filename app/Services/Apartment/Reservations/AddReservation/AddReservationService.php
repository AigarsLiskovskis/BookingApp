<?php

namespace App\Services\Apartment\Reservations\AddReservation;

use App\Repositories\Reservations\PDOReservationsRepository;
use App\Repositories\Reservations\ReservationsRepository;
use Doctrine\DBAL\Exception;

class AddReservationService
{
    private ReservationsRepository $reservationsRepository;

    public function __construct()
    {
        $this->reservationsRepository = new PDOReservationsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(AddReservationRequest $request)
    {
        $apartmentId = $request->getApartmentId();
        $userId = $request->getUserId();
        $reserveFrom = $request->getReservedFrom();
        $reserveTill = $request->getReservedTill();

        $this->reservationsRepository->addReservation($apartmentId, $userId, $reserveFrom, $reserveTill);
    }

}