<?php namespace GamingPassion;

    require __DIR__ . '/../vendor/autoload.php';

    require_once __DIR__ . '/../credentials.php';

	$connection = new Database(mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE));

    session_start();
    
	require_once 'database/connect.php';
	require_once 'functions/general-functions.php';
	require_once 'functions/posts-functions.php';
	require_once 'functions/users-functions.php';
	require_once 'functions/error-functions.php';

    if(isset($_SESSION['username'])){
	    $username = $_SESSION['username'];

        $data = mysqli_query($connection, "SELECT * FROM `users` WHERE username = '$username'");

        while($row = mysqli_fetch_array($data)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $email = $row['email'];
            $gender = $row['gender'];
            $home = $row['home'];
            $active = $row['active'];
            $joined = $row['joined'];
            $thumbnail = $row['thumbnail'];
            $status = $row['status'];
        }
    }

	if(empty($thumbnail)){
		$thumbnail = 'css/images/image-missing.jpg';	
	}

	$time =  date('H:i', time());
?>