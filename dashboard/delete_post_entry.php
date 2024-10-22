<?php include '../core/bootstrap.php'; ?>
<?php
	if(!loggedIn() || !adminUser()){
		if(!modUser()){
			header("Location: index.php");
			die();
		}
	}
?>
<?php
	$post_id = $_GET['post_id'];
	if(isset($post_id)){
	mysqli_query($connection, "UPDATE `posts` SET public = 0 WHERE $post_id = post_id");
	}else{
		header('Location: index.php');	
	}
	header('Location: articles.php?deleted');
?>