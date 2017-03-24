<?php
	$isMobile = false;
	$isBot = false;

	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ac = strtolower($_SERVER['HTTP_ACCEPT']);
	$ip = $_SERVER['REMOTE_ADDR'];

	$isMobile = strpos($ac, 'application/vnd.wap.xhtml+xml') !== false
			|| strpos($ua, 'sony') !== false
			|| strpos($ua, 'symbian') !== false
			|| strpos($ua, 'nokia') !== false
			|| strpos($ua, 'samsung') !== false
			|| strpos($ua, 'mobile') !== false
			|| strpos($ua, 'windows ce') !== false
			|| strpos($ua, 'epoc') !== false
			|| strpos($ua, 'opera mini') !== false
			|| strpos($ua, 'nitro') !== false
			|| strpos($ua, 'j2me') !== false
			|| strpos($ua, 'midp-') !== false
			|| strpos($ua, 'cldc-') !== false
			|| strpos($ua, 'netfront') !== false
			|| strpos($ua, 'mot') !== false
			|| strpos($ua, 'up.browser') !== false
			|| strpos($ua, 'up.link') !== false
			|| strpos($ua, 'audiovox') !== false
			|| strpos($ua, 'blackberry') !== false
			|| strpos($ua, 'ericsson,') !== false
			|| strpos($ua, 'panasonic') !== false
			|| strpos($ua, 'philips') !== false
			|| strpos($ua, 'sanyo') !== false
			|| strpos($ua, 'sharp') !== false
			|| strpos($ua, 'sie-') !== false
			|| strpos($ua, 'portalmmm') !== false
			|| strpos($ua, 'blazer') !== false
			|| strpos($ua, 'avantgo') !== false
			|| strpos($ua, 'danger') !== false
			|| strpos($ua, 'palm') !== false
			|| strpos($ua, 'series60') !== false
			|| strpos($ua, 'palmsource') !== false
			|| strpos($ua, 'pocketpc') !== false
			|| strpos($ua, 'smartphone') !== false
			|| strpos($ua, 'rover') !== false
			|| strpos($ua, 'ipaq') !== false
			|| strpos($ua, 'au-mic,') !== false
			|| strpos($ua, 'alcatel') !== false
			|| strpos($ua, 'ericy') !== false
			|| strpos($ua, 'up.link') !== false
			|| strpos($ua, 'vodafone/') !== false
			|| strpos($ua, 'wap1.') !== false
			|| strpos($ua, 'wap2.') !== false;

			$isBot =  $ip == '66.249.65.39'
			|| strpos($ua, 'googlebot') !== false
			|| strpos($ua, 'mediapartners') !== false
			|| strpos($ua, 'yahooysmcm') !== false
			|| strpos($ua, 'baiduspider') !== false
			|| strpos($ua, 'msnbot') !== false
			|| strpos($ua, 'slurp') !== false
			|| strpos($ua, 'ask') !== false
			|| strpos($ua, 'teoma') !== false
			|| strpos($ua, 'spider') !== false
			|| strpos($ua, 'heritrix') !== false
			|| strpos($ua, 'attentio') !== false
			|| strpos($ua, 'twiceler') !== false
			|| strpos($ua, 'irlbot') !== false
			|| strpos($ua, 'fast crawler') !== false
			|| strpos($ua, 'fastmobilecrawl') !== false
			|| strpos($ua, 'jumpbot') !== false
			|| strpos($ua, 'googlebot-mobile') !== false
			|| strpos($ua, 'yahooseeker') !== false
			|| strpos($ua, 'motionbot') !== false
			|| strpos($ua, 'mediobot') !== false
			|| strpos($ua, 'chtml generic') !== false
			|| strpos($ua, 'nokia6230i/. fast crawler') !== false;
			
			if($isMobile){
			   header('Location: http://miloszdura.com/techblog/mobile');
			   exit();
			}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gaming Passion | News, Reviews, Fun</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="icon" href="css/images/favicon.ico" type="image/x-icon" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css' />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>
		$(document).one('keydown',function(e){
		    $('#login').focus();
		});

		$(function(){	
			$("#slideshow > div:gt(0)").hide();
			setInterval(function() { 
			  $('#slideshow > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(1000)
			    .end()
			    .appendTo('#slideshow');
			},  6000);
		});

		$(function(){
			$('.green-message').delay(5000).fadeOut(400);
		});

		$(document).scroll(function() {
			var scrollTop = $(window).scrollTop();
			var elementOffset = $('#menu').offset().top;
			 distance = (elementOffset - scrollTop);
			bar_pos = distance;
			if (bar_pos <= 0) {
				document.getElementById("menu").style.top="0";
				document.getElementById("menu").style.position="fixed";
				document.getElementById("container").style.marginTop="65px";
			}
			if(scrollTop <= 150){
				document.getElementById("menu").style.top="0";
				document.getElementById("menu").style.position="static";
				document.getElementById("container").style.marginTop="15px";
			}
		});
		$(document).ready(function() {
		  var bodyHeight = $("body").height();
		  var vwptHeight = $(window).height();
		  if (vwptHeight > bodyHeight) {
		    $("#footer").css("position","absolute").css("bottom",0);
		  }
		});
	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-50985585-2', 'auto');
	  ga('send', 'pageview');

	</script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div class="container">
				<div class="float-left">
					<div style="width:0px;">
						<a href="/techblog"><img src="css/images/logo-main.jpg" alt="gaming passion logo" /></a>
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
										<li><a href="profile.php?user='.$username.'">My Account ('.$_SESSION['username'].')</a></li>
										<li><a href="badges.php">Badges</a></li>
										<li><a href="logout.php">Logout</a></li>
										<li><a href="messages.php">Private Messages</a></li>';

										if(adminUser($connection) || moduser($connection)){
											echo '
												<li><a href="/techblog/dashboard">Dashbaord</a></li>
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