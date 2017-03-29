<?php namespace GamingPassion\Services;

use GamingPassion\Factories\RatingFactory;

class RatingService
{
    private $ratingFactory;

    function __construct(RatingFactory $ratingFactory)
    {
        $this->ratingFactory = $ratingFactory;
    }

    public function getAllFor($postId){
        return  $this->ratingFactory->getAllRatingsFor($postId);
    }
}