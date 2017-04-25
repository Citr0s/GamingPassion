<?php namespace GamingPassion\Services;

class UserService
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }
}