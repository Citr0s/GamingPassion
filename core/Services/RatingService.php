<?php namespace GamingPassion\Services;

use GamingPassion\Database;
use GamingPassion\Factories\RatingFactory;

class RatingService
{
    private $database;
    private $ratingFactory;

    function __construct(Database $database, RatingFactory $ratingFactory)
    {
        $this->database = $database;
        $this->ratingFactory = $ratingFactory;
    }

    public function getAllFor($postId){
        return  $this->ratingFactory->getAllRatingsFor($postId);
    }
}