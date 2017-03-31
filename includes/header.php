<!DOCTYPE html>
<html lang="en" ng-app="gamingPassion">
<head>
	<meta charset="UTF-8">
	<title>Gaming Passion | News, Reviews, Fun</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="icon" href="css/images/favicon.ico" type="image/x-icon" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css' />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-50985585-2', 'auto');
	  ga('send', 'pageview');

	</script>
    <script src="../js/app.js"></script>
</head>
<body ng-controller="PostController">
	<div id="wrapper">
		<div id="header">
			<div class="container">
				<div class="float-left">
					<div style="width:0px;">
						<a href="/"><img src="css/images/logo-main.jpg" alt="gaming passion logo" /></a>
					</div>
				</div>
				<div class="float-right">
					<div id="login-area">
						<span class="greeting">Welcome to our website!</span>
						<span class="login-options">
						<?php
							if(isset($_SESSION['username'])){
								echo '
									<ul>
										<li><a href="profile.php?user='.$user->username.'">My Account ('.$user->username.')</a></li>
										<li><a href="badges.php">Badges</a></li>
										<li><a href="logout.php">Logout</a></li>
										<li><a href="messages.php">Private Messages</a></li>';

										if(adminUser($connection) || moduser($connection)){
											echo '
												<li><a href="/dashboard">Dashbaord</a></li>
											';
										}

								echo '
									</ul>
								';
							}else{
								echo '
									<ul>
										<li><a hrefg="login.php">My Account</a></li>
										<li><a href="login.php">Badges</a></li>
										<li><a href="login.php">Login</a></li>
										<li><a href="register.php">Register</a></li>
									</ul>
								';
							}
						?>
						</span>
						<span class="search">
							<form>
								<input type="text" name="search" class="search-box" placeholder="Search" />
								<button type="submit" class="button" style="margin-bottom:2px;"><i class="fa fa-search"></i></button>
							</form>
						</span>
					</div>
				</div>
				<div class="holder"></div>
			</div>
		</div>
		<div id="menu">
			<div class="container">
				<ul>
					<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
					<li><a href="news.php"><i class="fa fa-bolt"></i> News</a></li>
					<li><a href="reviews.php"><i class="fa fa-bar-chart-o"></i> Reviews</a></li>
					<li><a href="archive.php"><i class="fa fa-archive"></i> Archive</a></li>
					<li><a href=""><i class="fa fa-comments-o"></i> Forum</a></li>
				</ul>
			</div>
		</div>