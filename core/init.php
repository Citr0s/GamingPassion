<?php namespace GamingPassion;

    use GamingPassion\Services\PostService;

    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../credentials.php';

	$databaseInstance = new Database(mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE));
    $connection = $databaseInstance->connection;

    session_start();

	require_once 'Services/general-functions.php';
	require_once 'Services/users-functions.php';
	require_once 'Services/error-functions.php';

    if(isset($_SESSION['username']))
    {
        $user = $databaseInstance->getUserByUsername($_SESSION['username']);
    }

    $postService = new PostService($databaseInstance);
?>