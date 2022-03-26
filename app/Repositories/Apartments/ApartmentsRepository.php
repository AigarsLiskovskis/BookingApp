<?php

namespace App\Repositories\Apartments;

use Tests\Apartment;

interface ApartmentsRepository
{
    public function getById(int $apartmentId): Apartment;

    public function getAll(): array;

    public function create(Apartment $apartment): void;

    public function update(Apartment $apartment): void;

    public function delete(int $apartmentId): void;

    public function getPrice(int $apartmentId): int;
}

