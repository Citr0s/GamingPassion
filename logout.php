<?php include_once 'core/bootstrap.php'; ?>
<?php
	session_destroy();
	header("Location: index.php?logout");
?>