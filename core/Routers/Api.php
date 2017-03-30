<?php namespace GamingPassion\Routers;

class Api
{
    public static function handle($request)
    {
        if($request[0] === 'posts')
        {
            var_dump('test');
        }
    }
}