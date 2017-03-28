<?php
function sanitise($connection, $object){
	htmlentities(mysqli_real_escape_string($connection, $object));
}
function clear($object){
	htmlentities($object, ENT_QUOTES, 'UTF-8');	
}
function notVoted($connection, $post_id){
	$data = mysqli_query($connection, "SELECT * FROM `ratings` WHERE `post_id` = $post_id");

	while($row = mysqli_fetch_array($data)){
        if($row['author'] === $_SESSION['username']){
            return false;
        }
	}

	return true;
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