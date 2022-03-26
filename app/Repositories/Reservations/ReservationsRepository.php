<?php

namespace App\Repositories\Reservations;

interface ReservationsRepository
{
    public function getReservations(int $apartmentId): array;

    public function addReservation(int $apartmentId, int $userId, string $reservedFrom, string $reservedTill): void;
}
