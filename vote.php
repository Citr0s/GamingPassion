<?php 

	include_once 'core/bootstrap.php';

	if(!loggedIn()){
		header("Location: /login.php?login-required");
	}

	$post_id = $_GET['post_id'];
	$rating = $_GET['rating'];
	$username = $_SESSION['username'];

	if($rating < 1 || $rating > 5 || !loggedIn() || !notVoted($connection, $post_id)){
		header("Location: /");
	}else{
		mysqli_query($connection, "INSERT INTO `ratings` VALUES ('', $post_id, $rating, '$username')");
		header("Location: /?id=".$post_id."&thanks-for-voting");
	}

?>