<?php include_once 'core/init.php'; ?>
<?php
	session_destroy();
	header("Location: index.php?logout");
?>