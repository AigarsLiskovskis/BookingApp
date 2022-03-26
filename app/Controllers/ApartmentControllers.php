<?php

namespace App\Controllers;


use App\Redirect;
use App\Services\Apartment\CountMoney\GetPriceRequest;
use App\Services\Apartment\CountMoney\GetPriceService;
use App\Services\Apartment\Delete\DeleteApartmentRequest;
use App\Services\Apartment\Delete\DeleteApartmentService;
use App\Services\Apartment\Edit\EditApartmentRequest;
use App\Services\Apartment\Edit\EditApartmentService;
use App\Services\Apartment\Index\IndexApartmentService;
use App\Services\Apartment\Ratings\AddRating\AddRatingRequest;
use App\Services\Apartment\Ratings\AddRating\AddRatingService;
use App\Services\Apartment\Ratings\ApartmentRating\ApartmentRatingRequest;
use App\Services\Apartment\Ratings\ApartmentRating\ApartmentsRatingService;
use App\Services\Apartment\Ratings\UserRated\UserRatedRequest;
use App\Services\Apartment\Ratings\UserRated\UserRatedService;
use App\Services\Apartment\Reservations\AddReservation\AddReservationRequest;
use App\Services\Apartment\Reservations\AddReservation\AddReservationService;
use App\Services\Apartment\Reservations\ShowReservations\ShowReservationRequest;
use App\Services\Apartment\Reservations\ShowReservations\ShowReservationService;
use App\Services\Apartment\Show\ShowApartmentRequest;
use App\Services\Apartment\Show\ShowApartmentService;
use App\Services\Apartment\Create\CreateApartmentRequest;
use App\Services\Apartment\Create\CreateApartmentService;
use App\Services\Apartment\Update\UpdateApartmentRequest;
use App\Services\Apartment\Update\UpdateApartmentService;
use App\Services\Users\Names\UserNamesRequest;
use App\Services\Users\Names\UserNamesService;
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
        $apartments = (new IndexApartmentService())
            ->execute();

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
        $apartment = (new ShowApartmentService())
            ->execute(new ShowApartmentRequest((int)$input['id']));


        $startDate = $apartment->getAvailableFrom();
        $endDate = $apartment->getAvailableTill();


        $reservations = (new ShowReservationService())
            ->execute(new ShowReservationRequest((int)$input['id']));


        $ownerName = (new UserNamesService())
            ->execute(new UserNamesRequest($apartment->getUserId()));

        $rating = (new ApartmentsRatingService())
            ->execute(new ApartmentRatingRequest($apartment->getId()));

        $reviews = (new ReviewControllers())->showReviews($apartment->getId());

        $_SESSION['apartmentId'] = $apartment->getId();

        if (SessionControllers::isAuthorized()) {

            $userRated = (new UserRatedService())
                ->execute(new UserRatedRequest(
                    $apartment->getId(),
                    $_SESSION['userid']
                ));

            return new View('Apartments/show', [
                'apartment' => $apartment,
                'user' => $_SESSION['userid'],
                'rateButtons' => $userRated,
                'ownerName' => $ownerName,
                'rating' => $rating,
                'reviews' => $reviews,
                'userName' => $_SESSION['name'],
                'price' => $_SESSION['price'],
                'reservationDates' => $reservations,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'authorized' => true
            ]);
        } else {
            return new View('Apartments/show', [
                'apartment' => $apartment,
                'reservationDates' => $reservations,
                'ownerName' => $ownerName,
                'rating' => $rating,
                'reviews' => $reviews,
                'startDate' => $startDate,
                'endDate' => $endDate,
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
        (new CreateApartmentService())
            ->execute(new CreateApartmentRequest(
                $_POST['name'],
                $_POST['address'],
                trim($_POST['description']),
                $_SESSION["userid"],
                $_POST['price'],
                $_POST['availableFrom'],
                $_POST['availableTill']
            ));
        return new Redirect('/');

    }

    /**
     * @throws Exception
     */
    public function delete(array $input): Redirect
    {
        (new DeleteApartmentService())
            ->execute(new DeleteApartmentRequest((int)$input['id']));
        return new Redirect('/');
    }

    /**
     * @throws Exception
     */
    public function edit(array $input): View
    {
        $apartment = (new EditApartmentService())
            ->execute(new EditApartmentRequest((int)$input['id']));

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
        (new UpdateApartmentService())
            ->execute(new UpdateApartmentRequest(
                $_POST['name'],
                $_POST['address'],
                trim($_POST['description']),
                $_SESSION["userid"],
                $_POST['price'],
                $_POST['availableFrom'],
                $_POST['availableTill'],
                (int)$input['id']
            ));
        return new Redirect('/apartments/' . $input['id']);
    }

    /**
     * @throws Exception
     */
    public function ratings(array $input): Redirect
    {
        (new AddRatingService())
            ->execute(new AddRatingRequest(
                (int)$input['id'],
                $_SESSION["userid"],
                $_POST['rate']
            ));

        return new Redirect('/apartments/' . $input['id']);
    }

    /**
     * @throws Exception
     */
    public function countMoney(array $input): Redirect
    {
        $price = (new GetPriceService())
            ->execute(new GetPriceRequest(
                (int)$input['id']
            ));

        $startTimeStamp = strtotime($_POST['startDate']);

        $endTimeStamp = strtotime($_POST['endDate']);

        $timeDiff = abs($endTimeStamp - $startTimeStamp);

        $numberDays = $timeDiff / 86400;  // 86400 seconds in one day

        $numberDays = intval($numberDays);

        $_SESSION['price'] = $numberDays * $price;

        return new Redirect('/apartments/' . $input['id']);
    }

    /**
     * @throws Exception
     */
    public function reserve(array $input): Redirect
    {
        $this->countMoney($input);
        if ($_POST['endDate'] < $_POST['startDate']) {
            return new Redirect('/apartments/' . $input['id']);
        }

//        foreach ($reserveQuery as $reservation) {
//            if (($reservation["reserved_from"] <= $_POST['startDate']
//                    && $reservation['reserved_till'] >= $_POST['startDate']) ||
//                ($reservation["reserved_from"] <= $_POST['endDate']
//                    && $reservation['reserved_till'] >= $_POST['endDate'])) {
//                return new Redirect('/apartments/' . $input['id']);
//            }
//        }

        (new AddReservationService())
            ->execute(new AddReservationRequest(
                (int)$input['id'],
                $_SESSION["userid"],
                $_POST['startDate'],
                $_POST['endDate']
            ));

        return new Redirect('/apartments/' . $input['id']);
    }
}
