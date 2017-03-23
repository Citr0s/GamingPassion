<?php include 'core/init.php'; ?>
<?php
	if(!loggedIn()){
		header("Location: index.php");
		die();
	}
?>
<?php
	$message_id = $_GET['message_id'];
	$user = $_SESSION['username'];
	$message_count = 0;
		
	$data = mysql_query("SELECT * FROM `private_messages` WHERE `to` = '$user' AND `message_id` = $message_id LIMIT 1");
	
	while($row = mysql_fetch_array($data)){
		$message_count++;
	}
	
	$data = mysql_query("SELECT * FROM `private_messages` WHERE `from` = '$user' AND `message_id` = $message_id LIMIT 1");
	
	while($row = mysql_fetch_array($data)){
		$message_count = $message_count + 2;
	}
	
	if($message_count == 0){
		header('Location: index.php');
	}elseif($message_count == 1){
		if(isset($message_id)){
			mysql_query("UPDATE `private_messages` SET `active` = 0 WHERE `message_id` = $message_id");
		}else{
			header('Location: index.php');
		}
		header('Location: messages.php?deleted');
	}elseif($message_count == 2){
		if(isset($message_id)){
			mysql_query("UPDATE `private_messages` SET `active_from` = 0 WHERE `message_id` = $message_id");
		}else{
			header('Location: index.php');
		}
		header('Location: messages.php?deleted');
	}else{
		header('Location: index.php');
	}
?>