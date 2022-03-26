<?php

namespace App\Services\Reviews\Delete;

use App\Repositories\Reviews\PDOReviewsRepository;
use App\Repositories\Reviews\ReviewsRepository;
use Doctrine\DBAL\Exception;

class DeleteReviewsService
{
    private ReviewsRepository $reviewsRepository;

    public function __construct()
    {
        $this->reviewsRepository = new PDOReviewsRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteReviewRequest $request)
    {
        $id = $request->getId();

        $this->reviewsRepository->deleteReview($id);
    }

}

