<?php namespace GamingPassion\Routers;

Router::start(array_values(array_filter(explode('/', $_SERVER['REQUEST_URI']))));

class Router
{
    public static function start($request)
    {
        if($request[0] === 'api')
        {
            unset($request[0]);
            Api::handle(array_values($request));
        }
    }
}