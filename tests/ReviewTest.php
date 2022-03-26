<?php

namespace Tests;


use App\Models\Review;
use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase
{
    public function testGetReview()
    {
        $review = new Review(1,2,'review', 'user', 3, '22-03-2022');
        $this->assertSame('review', $review->getReview());

    }

    public function testGetUserId()
    {
        $review = new Review(1,2,'review', 'user', 3, '22-03-2022');
        $this->assertSame(3, $review->getUserId());

    }

    public function testGetId()
    {
        $review = new Review(1,2,'review', 'user', 3, '22-03-2022');
        $this->assertSame(1, $review->getId());
    }

    public function testGetCreatedBy()
    {
        $review = new Review(1,2,'review', 'user', 3, '22-03-2022');
        $this->assertSame('user', $review->getCreatedBy());

    }

    public function testGetCreatedAt()
    {
        $review = new Review(1,2,'review', 'user', 3, '22-03-2022');
        $this->assertSame('22-03-2022', $review->getCreatedAt());
    }

    public function testGetApartmentId()
    {
        $review = new Review(1,2,'review', 'user', 3, '22-03-2022');
        $this->assertSame(2, $review->getApartmentId());
    }
}
