<?php namespace GamingPassion\Routers;

use GamingPassion\Controllers\PostController;
use GamingPassion\Controllers\RatingController;

class Api
{
    public static function handle($request, $method)
    {
        if($request[0] === 'posts')
        {
            if($method === 'GET')
            {
                if(array_key_exists(1, $request) && is_numeric($request[1]))
                {
                    return PostController::single($request[1]);
                }

                return PostController::all();
            }
        }

        if($request[0] === 'ratings')
        {
            if($method === 'GET')
            {
                if(array_key_exists(1, $request) && is_numeric($request[1]))
                {
                    return RatingController::for($request[1]);
                }
            }
        }
    }
}