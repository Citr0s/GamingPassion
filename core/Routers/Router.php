<?php namespace GamingPassion\Routers;

Router::start();

class Router
{
    public static function start()
    {
        $request = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));

        if($request[0] === 'api')
        {
            unset($request[0]);
            Api::handle(array_values($request));
        }
    }
}