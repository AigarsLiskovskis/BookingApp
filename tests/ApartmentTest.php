<?php

namespace Tests;

use App\Models\Apartment;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{
    public function testGetId()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame(1, $apartment->getId());
    }

    public function testGetName()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame('name', $apartment->getName());
    }

    public function testGetAddress()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame('address', $apartment->getAddress());
    }

    public function testGetDescription()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame('description', $apartment->getDescription());
    }

    public function testGetUserId()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame(2, $apartment->getUserId());
    }

    public function testGetPrice()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame(30, $apartment->getPrice());
    }

    public function testGetAvailableFrom()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame('22-02-2022', $apartment->getAvailableFrom());
    }

    public function testGetAvailableTill()
    {
        $apartment = new Apartment('name', 'address',
            'description', 2, 30, '22-02-2022', '22-02-2022', 1);
        $this->assertSame('22-02-2022', $apartment->getAvailableTill());
    }

}
