<?php include '../core/bootstrap.php'; ?>
<?php
	$data = mysql_query("SELECT * FROM users WHERE '$_SESSION[username]' = username LIMIT 1");
	
	while($row = mysql_fetch_array($data)){
		$user_info = array($row['user_id'], $row['username'], $row['password'], $row['email'], $row['active'], $row['status']);
	}
?>
<?php
	if(loggedIn() == false || $user_info[5] != 'admin'){
		header("Location: ../index.php");
	}
?>
<?php
	$user_id = $_GET['user_id'];
	if(isset($user_id)){
	mysql_query("UPDATE `users` SET active = 0 WHERE $user_id = user_id");
	}else{
		header('Location: index.php');	
	}
	header('Location: users.php?deleted');
?>