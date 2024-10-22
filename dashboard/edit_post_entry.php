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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/request-styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Gaming-Passion.eu | Bo Gry to Nasza Pasja!" />
<meta name="keywords" content="gaming, passion, gry, to, nasza, pasja" />
<title>Dashboard | Gaming-Passion.eu</title>
</head>
<body>
	<div id="wrapper">
<?php
	
	$post_id = $_GET['post_id'];
	
	if(empty($_POST['post_title']) || empty($_POST['post_content']) || empty($_POST['post_author']) || empty($_POST['post_category']) || empty($_POST['tags'])){
			echo '<div class="red-message">Prosz&#281; wype&#322;ni&#263; wszystkie pola oznaczone gwiazdk&#261.</div>';
	}elseif(!empty($_POST['post_title']) && !empty($_POST['post_content']) && !empty($_POST['post_author']) && !empty($_POST['post_category']) && !empty($_POST['tags'])){

	if(!empty($_POST['filename'])){

		$data = mysql_query("SELECT * FROM `posts` WHERE $post_id = post_id");

		while($row = mysql_fetch_array($data)){
			$thumbnail = $row['thumbnail'];	
		}

		unlink("../".$thumbnail);

		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$length = 5;
		$newName = '';

		for($i = 0; $i < $length; $i++){
		    $newName .= $chars[mt_rand(0, 36)];
		}
	
	}
	if($_FILES){
		$name = $_FILES['filename']['name'];
		
		switch($_FILES['filename']['type']){
			case 'image/jpeg': 
				$ext = 'jpg';
				break;
			case 'image/gif': 
				$ext = 'gif';
				break;
			case 'image/png': 
				$ext = 'png';
				break;
			default: 
				$ext = '0';
				break;
		}
		
		if(empty($name)){
			echo "(Obrazek nie został zmieniony.)";
			$data = mysql_query("SELECT * FROM `posts` WHERE $post_id = post_id");
	
			while($row = mysql_fetch_array($data)){
				$thumbnail = $row['thumbnail'];
			}
		}else{
			$size = $_FILES['filename']['size'];
			if($size > 524288){
				echo "Obrazek jest za duży. Maxymalna wielkość to 500kb.";
				$data = mysql_query("SELECT * FROM `posts` WHERE $post_id = post_id");
		
				while($row = mysql_fetch_array($data)){
					$thumbnail = $row['thumbnail'];
				}
			}else{
				if($ext){
					$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
					$length = 5;
					$newName = '';

					for($i = 0; $i < $length; $i++){
					    $newName .= $chars[mt_rand(0, 36)];
					}
					
					$n = "../uploads/$newName.$ext";
					$thumbnail = "uploads/$newName.$ext";
					move_uploaded_file($_FILES['filename']['tmp_name'], $n);
				}else{
					echo "Nieprawidłowe rozszerzenie! ('$name')";
				}
			}
		}
		
	}else{
		echo "Obrazek nie został zmieniony.";
	}
		
		$post_title = $_POST['post_title'];
		$post_content = $_POST['post_content'];
		$post_author = $_POST['post_author'];
		$post_category = $_POST['post_category'];
		$tags = $_POST['tags'];
		
		mysql_query("UPDATE `posts` SET post_title = '$post_title', post_content = '$post_content', post_author = '$post_author', post_category = '$post_category', thumbnail = '$thumbnail', tags = '$tags' WHERE $post_id = post_id");	
			echo '<div class="green-message">Post zosta&#322; pomy&#347;lnie edytowany.</div>';
	}
	
	$data = mysql_query("SELECT * FROM `posts` WHERE $post_id = post_id");
	
	while($row = mysql_fetch_array($data)){
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_category = $row['post_category'];	
		$thumbnail = $row['thumbnail'];	
		$tags = $row['tags'];

		if(empty($thumbnail)){
			$thumbnail = '/assets/images/image-missing.jpg';
		}
		
		echo '
			<h1>Edit</h1>
			<h2>You are editing a post called <strong>'.$post_title.'</strong></h2>
			<form action="#" method="post" enctype="multipart/form-data">
				<table class="form-table" style="width:100%; margin:0px;">
					<tr>
						<td valign="middle">Title:</td><td><input type="text" name="post_title" value="'.$post_title.'"/></td>
					</tr>
					<tr>
						<td valign="middle">Post:</td><td><textarea name="post_content">'.$post_content.'</textarea></td>
					</tr>
					<tr>
						<td valign="middle" class="required">*Kategoria:</td><td><select name="post_category"><option value="'.$post_category.'">'.ucfirst($post_category).'</option><option value="news">News</option><option value="recenzja">Recenzja</option><option value="poradnik">Poradnik</option><option value="gameplay">Gameplay</option></select></td>
					</tr>
					<tr>
						<td valign="middle">Author:</td><td><input type="text" name="post_author" value="'.$post_author.'"/></td>
					</tr>
					<tr>
						<td valign="middle">Obrazek:</td><td><img src="../'.$thumbnail.'" height="100" /></td>
					</tr>
					<tr>
						<td valign="middle">Wybierz nowy obrazek:</td><td><input type="file" name="filename" /></td>
					</tr>
					<tr>
						<td valign="middle">Tagi:</td><td><input type="text" name="tags" value="'.$tags.'"/></td>
					</tr>
					<tr>
						<td valign="top"></td><td><button type="submit" class="button">Edit</button></td>
					</tr>
				</table>
			</form>
		';
	}
?>
	</div>
</body>
</html>