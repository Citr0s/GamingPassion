<?php include '../core/bootstrap.php'; ?>
<?php
	$data = mysql_query("SELECT * FROM comments WHERE '$_POST[comment_id]' = comment_id LIMIT 1");
?>
<?php
	if(loggedIn() == false || $user_info[5] != 'admin'){
		header("Location: ../index.php");
	}
?><?php
	$comment_id = $_GET['comment_id'];
	if(isset($comment_id)){
	mysql_query("UPDATE `comments` SET active = 0 WHERE $comment_id = comment_id");
	}else{
		header('Location: index.php');	
	}
	header('Location: comments.php?activated');
?>