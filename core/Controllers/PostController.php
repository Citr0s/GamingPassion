<?php namespace GamingPassion\Controllers;

use GamingPassion\Database;
use GamingPassion\Factories\PostFactory;
use GamingPassion\Services\PostService;

require_once __DIR__ . '/../../credentials.php';

class PostController
{
    public static function all()
    {
        return 'test';
        $mysqlClient = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $database = new Database($mysqlClient);
        $postService = new PostService($database, new PostFactory($database));

        return $postService->getAll();
    }
}