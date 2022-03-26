<?php

namespace App\Repositories\Reservations;

use App\Database;
use Carbon\CarbonPeriod;
use Doctrine\DBAL\Exception;

class PDOReservationsRepository implements ReservationsRepository
{
    /**
     * @throws Exception
     */
    public function getReservations(int $apartmentId): array
    {
        $reserveQuery = Database::connection()
            ->createQueryBuilder()
            ->select('reserved_from', 'reserved_till')
            ->from('reservations')
            ->where('apartment_id=?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();

        $reservations =[];
        foreach ($reserveQuery as $record){
            $startDate = $record['reserved_from'];
            $endDate = $record['reserved_till'];

            $period = CarbonPeriod::create($startDate,$endDate);
            foreach ($period as $date)
            {
                $reservations[] =  $date->format('Y-m-d');
            }
        }
        return $reservations;
    }

    /**
     * @throws Exception
     */
    public function addReservation(int $apartmentId, int $userId, string $reservedFrom, string $reservedTill): void
    {
        Database::connection()
            ->insert('reservations',
                [
                    'apartment_id' => $apartmentId,
                    'user_id' => $userId,
                    'reserved_from' => $reservedFrom,
                    'reserved_till' => $reservedTill
                ]);
    }
}