<?php include 'core/init.php'; ?>
<?php
	if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password_check']) || empty($_POST['email'])){
		header("Location: register.php?error=1");
	}elseif(!empty($_POST['username']) || !empty($_POST['password']) || !empty($_POST['password_check']) || !empty($_POST['email'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_check = $_POST['password_check'];
		$email = $_POST['email'];
		$response = $_POST['g-recaptcha-response'];
		
		if(strlen($username) < 4 || strlen($password) < 4){
			header("Location: register.php?error=2");
		}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: register.php?error=6");
		}else{
			if($password != $password_check){
				header("Location: register.php?error=3");
			}else{
				$data = mysql_query("SELECT * FROM `users`");
				$i = 0;
				while($row = mysql_fetch_array($data)){
					if($username == $row['username']){
						$i = 1;
						header("Location: register.php?error=4");
					}elseif($email == $row['email']){
						$i = 1;
						header("Location: register.php?error=5");
					}
				}
				if(!empty($response)){
					$url = 'https://www.google.com/recaptcha/api/siteverify?secret=6LeXsf4SAAAAAFWnf2InV1jw6icig2o_yNUR_9Lb&response='.$response;
					$content = file_get_contents($url);
					$json = json_decode($content, true);
					
					if(isset($json['error-codes'])){
						header("Location: register.php?error=7");
					}elseif(isset($json['success'])){
						$password = md5($password);
						if($i != 1){
							mysql_query("INSERT INTO `users` (username, password, email, active, status, joined) VALUES ('$username', '$password', '$email', 1, 'user', CURRENT_TIMESTAMP)");
							header("Location: register.php?success");
						}
					}
				}else{
					header("Location: register.php?error=7");
				}
			}
		}
	}
?>