<?php 

	include_once 'core/init.php';

	if(!loggedIn()){
		header("Location: login.php?login-required");
	}

	$post_id = $_GET['post_id'];
	$rating = $_GET['rating'];
	$username = $_SESSION['username'];

	if($rating < 1 || $rating > 5 || !loggedIn() || !notVoted($post_id)){
		header("Location: index.php");
	}else{
		mysql_query("INSERT INTO `ratings` VALUES ('', $post_id, $rating, '$username')");
		header("Location: index.php?id=".$post_id."&thanks-for-voting");
	}

?>