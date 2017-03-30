<?php namespace GamingPassion\Controllers;

use GamingPassion\Database;

require_once __DIR__ . '/../../credentials.php';

class Controller
{
    public static function database()
    {
        $mysqlClient = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        return new Database($mysqlClient);
    }
}