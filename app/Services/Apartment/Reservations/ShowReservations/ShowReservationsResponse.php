<?php

namespace App\Services\Apartment\Reservations\ShowReservations;

class ShowReservationsResponse
{
    private array $reservations;

    public function __construct(array $reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     * @return array
     */
    public function getReservations(): array
    {
        return $this->reservations;
    }
}