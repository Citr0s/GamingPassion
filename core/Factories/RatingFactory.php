<?php namespace GamingPassion\Factories;

use GamingPassion\Database;
use GamingPassion\Models\GetAllRatingsResponse;
use GamingPassion\Models\Rating;

class RatingFactory
{
    private $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllRatingsFor($postId)
    {
        $ratings = [];
        $totalRatings = 0;

        $databaseResponse = $this->database->connection->query( "SELECT * FROM `ratings` WHERE `post_id` = {$postId}");

        while($row = $databaseResponse->fetch_assoc())
        {
            $rating = new Rating();

            $rating->score = $row['rating'];
            $rating->author = $row['author'];

            $totalRatings += $rating->score;

            array_push($ratings, $rating);
        }

        $response = new GetAllRatingsResponse();

        if($totalRatings === 0){
            return $response;
        }

        $response->ratings = $ratings;
        $response->average = round($totalRatings / sizeof($ratings), 1);

        return $response;
    }
}