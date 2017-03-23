<?php include '../core/init.php'; ?>
<?php
	$data = mysql_query("SELECT * FROM users WHERE '$_SESSION[username]' = username LIMIT 1");
	
	while($row = mysql_fetch_array($data)){
		$user_info = array($row['user_id'], $row['username'], $row['password'], $row['email'], $row['active'], $row['status']);
	}
?>
<?php
	if(loggedIn() == false || $user_info[5] != 'admin'){
		if($user_info[5] == 'mod'){
			echo '';
		}else{
			header("Location: ../index.php");	
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/request-styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Gaming-Passion.eu | Bo Gry to Nasza Pasja!" />
<meta name="keywords" content="gaming, passion, gry, to, nasza, pasja" />
<title>Dashboard | Gaming-Passion.eu</title>
</head>
<body>
	<div id="wrapper">
<?php
	$user_id = $_GET['user_id'];
	
	if(empty($_POST['email']) || empty($_POST['status'])){
			echo '<div class="red-message">Please fill in all the required fields.</div>';
	}elseif(!empty($_POST['email']) && !empty($_POST['status'])){
		if($_POST['status'] == 'user' || $_POST['status'] == 'admin' || $_POST['status'] == 'mod'){

			$email = $_POST['email'];
			$status = $_POST['status'];

			mysql_query("UPDATE `users` SET `email` = '$email', `status` = '$status' WHERE `user_id` = $user_id");
			echo '<div class="green-message">User has been edited successfully.</div>';
		}else{
			echo '<div class="red-message">This status is invalid. Use <strong>user</strong>, <strong>mod</strong> or <strong>admin</strong>.</div>';
		}
	}

	$data = mysql_query("SELECT * FROM `users` WHERE $user_id = user_id LIMIT 1");
	
	while($row = mysql_fetch_array($data)){
		$username = $row['username'];
		$email = $row['email'];
		$status = $row['status'];
						
		echo '
			<h1>Edit</h1>
			<h2>You are editing <strong>'.$username.'</strong></h2>
			<form action="#" method="post">
				<table class="form-table" style="width:100%; margin:0px;">
					<tr>
						<td valign="middle">Email:</td><td><input type="email" name="email" value="'.$email.'"/></td>
					</tr>
					<tr>
						<td valign="middle">Status:</td><td><input type="text" name="status" value="'.$status.'"';
						if($user_info[5] == 'mod'){
							echo 'disabled="disabled" /></td><td><div style="visibility:hidden;"><input type="text" name="status" value="'.$status.'" /></div>';
						}
		echo '</td>
					</tr>
					<tr>
						<td valign="top"></td><td><input type="submit" value="Edit" class="button" /></td>
					</tr>
					<tr>
				</table>
			</form>
		';
	}
?>
	</div>
</body>
</html>