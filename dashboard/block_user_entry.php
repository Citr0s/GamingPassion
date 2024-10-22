<?php include '../core/bootstrap.php'; ?>
<?php
	$data = mysqli_query($connection, "SELECT * FROM users WHERE '$_SESSION[username]' = username LIMIT 1");
	
	while($row = mysqli_fetch_array($data)){
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
	mysqli_query($connection, "UPDATE `users` SET active = 0 WHERE $user_id = user_id");
	}else{
		header('Location: /');	
	}
	header('Location: users.php?deleted');
?>