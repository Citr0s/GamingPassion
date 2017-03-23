<?php include 'core/init.php'; ?>
<?php
	if(!loggedIn()){
		header("Location: index.php");
		die();
	}
?>
<?php
	$user = $_SESSION['username'];
	$data = mysql_query("SELECT * FROM `private_messages` WHERE `from` = '$user' ORDER BY `timestamp` DESC LIMIT 1");
	
	while($row = mysql_fetch_array($data)){
		$last_comment_time = $row['timestamp'];
	}
	
	$last_comment_time = strtotime($last_comment_time);
	$today = time();

	$time_difference = $today - $last_comment_time;
	
	if(isset($_POST['send-to-all'])){
		$to = 'admin';	
	}
	
	$title = $_POST['title'];
	$to = $_POST['to'];
	$content = nl2br($_POST['content']);
	$bot_check = $_POST['bot-check'];

	if($user == $to){
		header('Location: messages.php?self');
		die();
	}
	
	$datax = mysql_query("SELECT * FROM `users` WHERE `username` = '$to' LIMIT 1");
	$user_count = 0;
	while($row = mysql_fetch_array($datax)){
		$user_count++;
	}
	
	if($bot_check == 'Warszawa' || $bot_check == 'warszawa'){
		if(!empty($title) && !empty($to) && !empty($content)){
			if($time_difference < 300){
				header('Location: messages.php?time');
			}elseif($user_count == 0){
				header('Location: messages.php?user-doesnt-exist');
			}else{
				mysql_query("INSERT INTO `private_messages` (`title`, `content`, `timestamp`, `from`, `to`, `active`) VALUES ('$title', '$content', CURRENT_TIMESTAMP, '$user', '$to', 1)");
				header('Location: messages.php?success');
			}
		}else{
			header('Location: messages.php?fields-not-set');
		}
	}else{
		header('Location: messages.php?bot-alert');
	}
?>