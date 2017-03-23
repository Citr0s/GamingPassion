<?php
	$mysql_host = "localhost";
	$mysql_database = "techBlog";
	$mysql_user = "root";
	$mysql_password = "rYURJU9navJYYfcs";
	
	mysql_connect($mysql_host, $mysql_user, $mysql_password) or die ('There was an error with loging into the database.');
	
	mysql_select_db($mysql_database) or die ('There was an error with connecting to the database.');
?>