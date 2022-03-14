<?php

namespace App\Controllers;

use App\Database;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Apartment;
use App\Models\Article;
use App\Redirect;
use App\Validation\Errors;
use App\Views\View;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Doctrine\DBAL\Exception;

class ApartmentControllers
{
    /**
     * @throws Exception
     */
    public function index(): View
    {
        $query = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->executeQuery()
            ->fetchAllAssociative();

        $apartments = [];
        foreach ($query as $item) {
            $apartments[] = new Apartment(
                $item['id'],
                $item['name'],
                $item['address'],
                $item['description'],
                $item['user_id'],
                $item['price'],
                $item['available_from'],
                $item['available_till']
            );
        }

        if (SessionControllers::isAuthorized()) {
            return new View('Apartments/index', [
                'apartments' => $apartments,
                'authorized' => true,
                'userName' => $_SESSION['name'],
                'user' => $_SESSION['userid'],
            ]);
        } else {
            return new View('Apartments/index', [
                'apartments' => $apartments,
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function show(array $input): View
    {
        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id=?')
            ->setParameter(0, (int)$input['id'])
            ->executeQuery()
            ->fetchAssociative();


        $apartment = new Apartment(
            $apartmentQuery['id'],
            $apartmentQuery['name'],
            $apartmentQuery['address'],
            $apartmentQuery['description'],
            $apartmentQuery['user_id'],
            $apartmentQuery['price'],
            $apartmentQuery['available_from'],
            $apartmentQuery['available_till']
        );

        var_dump($apartmentQuery['available_from']);

        $_SESSION['apartmentId'] = $apartmentQuery['id'];


        $reserveQuery = Database::connection()
            ->createQueryBuilder()
            ->select('reserved_from', 'reserved_till')
            ->from('reservations')
            ->where('apartment_id=?')
            ->setParameter(0, (int)$input['id'])
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




        $reviews = (new ReviewControllers())->showReviews($apartmentQuery['id']);

        $ownerQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id =?')
            ->setParameter(0, $apartmentQuery['user_id'])
            ->executeQuery()
            ->fetchAssociative();

        $ownerName = $ownerQuery['name'] . ' ' . $ownerQuery['surname'];

        $ratingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('avg(rating)')
            ->from('ratings')
            ->where('apartment_id =?')
            ->setParameter(0, $apartmentQuery['id'])
            ->executeQuery()
            ->fetchAssociative();

        $rating = round($ratingQuery['avg(rating)']) ?? 0;

        if (SessionControllers::isAuthorized()) {

            $rateQuery = Database::connection()
                ->createQueryBuilder()
                ->select('id')
                ->from('ratings')
                ->where("apartment_id = {$apartmentQuery['id']}")
                ->andWhere("user_id = {$_SESSION['userid']}")
                ->executeQuery()
                ->fetchAssociative();

            return new View('Apartments/show', [
                'apartment' => $apartment,
                'reservations' => $reserveQuery,
                'user' => $_SESSION['userid'],
                'rateButtons' => !$rateQuery,
                'ownerName' => $ownerName,
                'rating' => $rating,
                'reviews' => $reviews,
                'userName' => $_SESSION['name'],
                'price' => $_SESSION['price'],
                'reservationDates' =>$reservations,
                'authorized' => true
            ]);
        } else {
            return new View('Apartments/show', [
                'reservationDates' =>$reservations,
                'apartment' => $apartment,
                'ownerName' => $ownerName,
                'rating' => $rating,
                'reviews' => $reviews,
                'price' => $_SESSION['price'],
            ]);
        }
    }

    public function create(): View
    {
        return new View('Apartments/create', [
            'userName' => $_SESSION['name'],
            'authorized' => true,
        ]);
    }


    /**
     * @throws Exception
     */
    public function store(): Redirect
    {
        Database::connection()
            ->insert('apartments', [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'description' => trim($_POST['description']),
                'user_id' => ($_SESSION["userid"]),
                'price' => $_POST['price'],
                'available_from' => $_POST['availableFrom'],
                'available_till' => $_POST['availableTill']
            ]);
        return new Redirect('/apartments');

    }


    /**
     * @throws Exception
     */
    public function delete(array $input): Redirect
    {
        var_dump("hello");
        Database::connection()
            ->delete('apartments', ['id' => (int)$input['id']]);
        return new Redirect('/apartments');
    }


    /**
     * @throws Exception
     */
    public function edit(array $input): View
    {
        $editQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id =?')
            ->setParameter(0, $input['id'])
            ->executeQuery()
            ->fetchAssociative();

        $apartment = new Apartment(
            $editQuery['id'],
            $editQuery['name'],
            $editQuery['address'],
            $editQuery['description'],
            $editQuery['user_id'],
            $editQuery['price'],
            $editQuery['available_from'],
            $editQuery['available_till']
        );

        return new View('Apartments/update', [
            'apartment' => $apartment,
            'userName' => $_SESSION['name'],
            'authorized' => true,
        ]);

    }


    /**
     * @throws Exception
     */
    public function update(array $input): Redirect
    {
        Database::connection()
            ->update('apartments',
                [
                    'name' => $_POST['name'],
                    'address' => $_POST['address'],
                    'description' => $_POST['description'],
                    'user_id' => $_SESSION["userid"],
                    'price' => $_POST['price'],
                    'available_from' => $_POST['availableFrom'],
                    'available_till' => $_POST['availableTill'],
                ],
                ['id' => (int)$input['id']]);
        return new Redirect('/apartments/' . $input['id']);
    }


    /**
     * @throws Exception
     */
    public function ratings(array $input): Redirect
    {
        Database::connection()
            ->insert('ratings',
                [
                    'apartment_id' => (int)$input['id'],
                    'user_id' => $_SESSION["userid"],
                    'rating' => $_POST['rate']
                ]);
        return new Redirect('/apartments/' . $input['id']);
    }


    /**
     * @throws Exception
     */
    public function countMoney(array $input): Redirect
    {
        $reserveQuery = Database::connection()
            ->createQueryBuilder()
            ->select('price')
            ->from('apartments')
            ->where('id=?')
            ->setParameter(0, (int)$input['id'])
            ->executeQuery()
            ->fetchAssociative();
        $startTimeStamp = strtotime($_POST['startDate']);

        $endTimeStamp = strtotime($_POST['endDate']);

        $timeDiff = abs($endTimeStamp - $startTimeStamp);

        $numberDays = $timeDiff / 86400;  // 86400 seconds in one day

        $numberDays = intval($numberDays);

        $_SESSION['price'] = $numberDays * $reserveQuery['price'];

        return new Redirect('/apartments/' . $input['id']);
    }

    /**
     * @throws Exception
     */
    public function reserve(array $input): Redirect
    {
        $reserveQuery = Database::connection()
            ->createQueryBuilder()
            ->select('reserved_from', 'reserved_till')
            ->from('reservations')
            ->where('apartment_id=?')
            ->setParameter(0, (int)$input['id'])
            ->executeQuery()
            ->fetchAllAssociative();


        if ($_POST['endDate'] < $_POST['startDate']) {
            return new Redirect('/apartments/' . $input['id']);
        }
        foreach ($reserveQuery as $reservation) {
            if (($reservation["reserved_from"] <= $_POST['startDate']
                    && $reservation['reserved_till'] >= $_POST['startDate']) ||
                ($reservation["reserved_from"] <= $_POST['endDate']
                    && $reservation['reserved_till'] >= $_POST['endDate'])) {
                return new Redirect('/apartments/' . $input['id']);
            }
        }
        Database::connection()
            ->insert('reservations',
                [
                    'apartment_id' => (int)$input['id'],
                    'user_id' => $_SESSION["userid"],
                    'reserved_from' => $_POST['startDate'],
                    'reserved_till' => $_POST['endDate']
                ]);
        return new Redirect('/apartments/' . $input['id']);
    }
}
