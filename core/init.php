<?php namespace GamingPassion;

    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../credentials.php';

	$databaseInstance = new Database(mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE));
    $connection = $databaseInstance->connection;

    session_start();

	require_once 'functions/general-functions.php';
	require_once 'functions/posts-functions.php';
	require_once 'functions/users-functions.php';
	require_once 'functions/error-functions.php';

    if(isset($_SESSION['username']))
    {
        $user = $databaseInstance->getUserByUsername($_SESSION['username']);
    }
?>