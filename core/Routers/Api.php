<?php namespace GamingPassion\Routers;

use GamingPassion\Controllers\PostController;

class Api
{
    public static function handle($request, $method)
    {
        if($request[0] === 'posts')
        {
            if($method === 'GET')
            {
                PostController::all();
            }
        }
    }
}