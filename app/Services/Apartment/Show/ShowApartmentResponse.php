<?php

namespace App\Services\Apartment\Show;

use Tests\Apartment;

class ShowApartmentResponse
{
    private Apartment $apartment;

    public function __construct(Apartment $apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * @return Apartment
     */
    public function getApartment(): Apartment
    {
        return $this->apartment;
    }

}