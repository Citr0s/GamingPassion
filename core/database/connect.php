<?php
    require_once('../../credentials.php');

	$mysql_host = $DB_HOST;
	$mysql_database = $DB_DATABASE;
	$mysql_user = $DB_USER;
	$mysql_password = $DB_PASSWORD;
	
	mysql_connect($mysql_host, $mysql_user, $mysql_password) or die ('There was an error with loging into the database.');
	
	mysql_select_db($mysql_database) or die ('There was an error with connecting to the database.');
?>