<?php include '../core/bootstrap.php'; ?>
<?php
	$data = mysqli_query($connection, "SELECT * FROM comments WHERE '$_POST[comment_id]' = comment_id LIMIT 1");
?>
<?php
	if(loggedIn() == false || $user_info[5] != 'admin'){
		header("Location: ../index.php");
	}
?><?php
	$comment_id = $_GET['comment_id'];
	if(isset($comment_id)){
	mysqli_query($connection, "UPDATE `comments` SET active = 0 WHERE $comment_id = comment_id");
	}else{
		header('Location: /');	
	}
	header('Location: comments.php?activated');
?>