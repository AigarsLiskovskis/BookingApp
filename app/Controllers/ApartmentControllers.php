<?php

namespace App\Controllers;

use App\Database;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Apartment;
use App\Models\Article;
use App\Redirect;
use App\Validation\Errors;
use App\Views\View;
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
                $item['available_from'],
                $item['available_till']
            );
        }

        if (SessionControllers::isAuthorized()) {
            return new View('Apartments/index', [
                'apartments' => $apartments,
                'authorized' => true,
                'userName' => $_SESSION['name']
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
            $apartmentQuery['available_from'],
            $apartmentQuery['available_till']
        );


        $reserveQuery = Database::connection()
            ->createQueryBuilder()
            ->select('reserved_from', 'reserved_till')
            ->from('reservations')
            ->where('apartment_id=?')
            ->setParameter(0, (int)$input['id'])
            ->executeQuery()
            ->fetchAllAssociative();


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
                'authorized' => true
            ]);
        } else {
            return new View('Apartments/show', [
                'apartment' => $apartment,
                'ownerName' => $ownerName,
                'rating' => $rating,
                'reviews' => $reviews,
            ]);
        }
    }

    public function create(): View
    {
        return new View('Apartments/create', [
            'userName' => $_SESSION['name']
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
            $editQuery['available_from'],
            $editQuery['available_till']
        );

        return new View('Apartments/update', [
            'apartment' => $apartment,
            'userName' => $_SESSION['name']
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
