<?php include 'core/init.php'; ?>
<?php 
	if(!loggedIn()){
		header("Location: index.php");
	}
	if(isset($_POST['username'])){
		loginCheck($_POST['username'], $_POST['password']);
	}else{
		header("Location: index.php");
	}
?>