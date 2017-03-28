<?php namespace GamingPassion\Services;

use GamingPassion\Database;

class RatingService
{
    private $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllFor($postId){
        return  $this->database->getAllRatingsFor($postId);
    }
}