<?php namespace GamingPassion\Routers;

require __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');

echo json_encode(Router::start(array_values(array_filter(explode('/', $_SERVER['REQUEST_URI']))), $_SERVER['REQUEST_METHOD']), JSON_PRETTY_PRINT);

class Router
{
    public static function start($request, $method)
    {
        if($request[0] === 'api')
        {
            unset($request[0]);
            return Api::handle(array_values($request), $method);
        }
    }
}