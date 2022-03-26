<?php

namespace App\Services\Apartment\Edit;


use Tests\Apartment;

class EditApartmentResponse
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