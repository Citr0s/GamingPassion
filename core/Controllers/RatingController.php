<?php namespace GamingPassion\Controllers;

use GamingPassion\Factories\RatingFactory;
use GamingPassion\Services\RatingService;

class RatingController extends Controller
{
    public static function for($postId)
    {
        $postService = new RatingService(new RatingFactory(self::database()));
        return $postService->getAllFor($postId);
    }
}