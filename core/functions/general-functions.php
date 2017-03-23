<?php
function sanitise($object){
	htmlentities(mysql_real_escape_string($object));
}
function clear($object){
	htmlentities($object, ENT_QUOTES, 'UTF-8');	
}
function notVoted($post_id){
	$data = mysql_query("SELECT * FROM `ratings` WHERE `post_id` = $post_id");

	while($row = mysql_fetch_array($data)){
		$author = $row['author'];
	}

	if($author != $_SESSION['username']){
		return true;
	}
}
function generateNewPassword($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>