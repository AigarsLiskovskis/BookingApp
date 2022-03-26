<?php

namespace App\Services\Apartment\CountMoney;

class GetPriceResponse
{
    private int $price;

    public function __construct(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}