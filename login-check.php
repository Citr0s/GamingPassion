<?php include 'core/bootstrap.php'; ?>
<?php
	if(isset($_POST['username'])){
		loginCheck($connection, $_POST['username'], $_POST['password']);
	}else{
		header("Location: /");
	}
?>