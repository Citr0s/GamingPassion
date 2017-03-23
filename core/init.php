<?php
	session_start();
	
	require_once 'database/connect.php';
	require_once 'functions/general-functions.php';
	require_once 'functions/posts-functions.php';
	require_once 'functions/users-functions.php';
	require_once 'functions/error-functions.php';
	
	error_reporting(0);

	$username = $_SESSION['username'];

	$data = mysql_query("SELECT * FROM `users` WHERE username = '$username'");	
	
	while($row = mysql_fetch_array($data)){
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

	if(empty($thumbnail)){
		$thumbnail = 'css/images/image-missing.jpg';	
	}

	$time =  date('H:i', time());
?>