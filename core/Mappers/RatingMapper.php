<?php namespace GamingPassion\Mappers;


use GamingPassion\Models\Rating;

class RatingMapper
{
    public static function map($record) : Rating
    {
        $rating = new Rating();

        $rating->score = $record['rating'];
        $rating->author = $record['author'];

        return $rating;
    }
}