<?php include '../core/bootstrap.php'; ?>
<?php
	if(!loggedIn() || !adminUser($connection)){
		if(!modUser($connection)){
			header("Location: /");
			die();
		}
	}
?>
<?php
	$post_id = $_GET['post_id'];
	if(isset($post_id)){
	mysqli_query($connection, "UPDATE `posts` SET public = 1 WHERE $post_id = post_id");
	}else{
		header('Location: /');	
	}
	header('Location: articles.php?published');
?>