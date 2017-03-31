<?php namespace GamingPassion\Routers;

require __DIR__ . '/../../vendor/autoload.php';

echo Router::start(array_values(array_filter(explode('/', $_SERVER['REQUEST_URI']))), $_SERVER['REQUEST_METHOD']);

class Router
{
    public static function start($request, $method)
    {
        if(!array_key_exists(0, $request))
        {
            return Site::handle(array_values($request), $method);
        }

        if($request[0] === 'api')
        {
            unset($request[0]);

            header('Content-Type: application/json');

            return json_encode(Api::handle(array_values($request), $method));
        }
    }
}