<?php
    require_once __DIR__ . '../../credentials.php';

	$mysql_host = DB_HOST;
	$mysql_database = DB_DATABASE;
	$mysql_user = DB_USERNAME;
	$mysql_password = DB_PASSWORD;
	
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password) or die ('There was an error with loging into the database.');
	
	mysqli_select_db($connection, $mysql_database) or die ('There was an error with connecting to the database.');