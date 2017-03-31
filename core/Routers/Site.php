<?php namespace GamingPassion\Routers;

use GamingPassion\Controllers\PageController;

class Site
{
    public static function handle($request, $method)
    {
        if(empty($request))
        {
            if($method === 'GET')
            {
                return PageController::index();
            }
        }
    }
}