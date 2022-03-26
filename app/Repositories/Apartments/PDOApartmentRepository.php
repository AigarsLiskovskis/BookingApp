<?php

namespace App\Repositories\Apartments;

use App\Database;
use Tests\Apartment;
use Doctrine\DBAL\Exception;

class PDOApartmentRepository implements ApartmentsRepository
{
    /**
     * @throws Exception
     */
    public function getById(int $apartmentId): Apartment
    {
        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id =?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAssociative();

        return new Apartment(
            $apartmentQuery['name'],
            $apartmentQuery['address'],
            $apartmentQuery['description'],
            $apartmentQuery['user_id'],
            $apartmentQuery['price'],
            $apartmentQuery['available_from'],
            $apartmentQuery['available_till'],
            $apartmentQuery['id'],
        );
    }

    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        $queryApartments = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->executeQuery()
            ->fetchAllAssociative();

        $apartments = [];
        foreach ($queryApartments as $item) {
            $apartments[] = new Apartment(

                $item['name'],
                $item['address'],
                $item['description'],
                $item['user_id'],
                $item['price'],
                $item['available_from'],
                $item['available_till'],
                $item['id'],
            );
        }
        return $apartments;
    }

    /**
     * @throws Exception
     */
    public function create(Apartment $apartment): void
    {
        Database::connection()
            ->insert('apartments', [
                'name' => $apartment->getName(),
                'address' => $apartment->getAddress(),
                'description' => $apartment->getDescription(),
                'user_id' => $apartment->getUserId(),
                'price' => $apartment->getPrice(),
                'available_from' => $apartment->getAvailableFrom(),
                'available_till' => $apartment->getAvailableTill(),
            ]);
    }

    /**
     * @throws Exception
     */
    public function update(Apartment $apartment):void
    {
        Database::connection()
            ->update('apartments',
                [
                    'name' => $apartment->getName(),
                    'address' => $apartment->getAddress(),
                    'description' => $apartment->getDescription(),
                    'user_id' => $apartment->getUserId(),
                    'price' => $apartment->getPrice(),
                    'available_from' => $apartment->getAvailableFrom(),
                    'available_till' => $apartment->getAvailableTill(),
                ],
                ['id' => $apartment->getId()]);
    }

    /**
     * @throws Exception
     */
    public function delete(int $apartmentId): void
    {
        Database::connection()
            ->delete('apartments', ['id' => $apartmentId]);
    }

    /**
     * @throws Exception
     */
    public function getPrice(int $apartmentId): int
    {
        $reserveQuery = Database::connection()
            ->createQueryBuilder()
            ->select('price')
            ->from('apartments')
            ->where('id=?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAssociative();

        return $reserveQuery['price'];
    }
}

