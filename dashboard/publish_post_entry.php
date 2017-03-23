<?php include '../core/init.php'; ?>
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
	mysql_query("UPDATE `posts` SET public = 1 WHERE $post_id = post_id");
	}else{
		header('Location: index.php');	
	}
	header('Location: articles.php?published');
?>