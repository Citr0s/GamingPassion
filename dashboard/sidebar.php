<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gaming Passion Dashboard | News, Reviews, Fun</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	<link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<script>
		var seconds, minutes, hours;
		var currentDate = new Date(<?php echo time() * 1000 ?>);
		seconds = currentDate.getSeconds();
		minutes = currentDate.getMinutes();
		hours = currentDate.getHours();

		if(seconds < 10){
			seconds = "0" + seconds;
		}
		if(minutes < 10){
			minutes = "0" + minutes;
		}
		if(hours < 10){
			hours = "0" + hours;
		}

		function progressTime(){
			if(seconds >= 59){
				if(minutes >= 59){
					if(hours >= 23){
						hours = "00";
					}else{
						if(hours < 10){
							hours++;
							hours = "0" + hours;
						}else{
							hours++;
						}
						minutes = "00";
					}
				}else{
					if(minutes < 10){
						minutes++;
						minutes = "0" + minutes;
					}else{
						minutes++;
					}
				}
				seconds = "00";
			}else{
				if(seconds < 9){
					seconds++;
					seconds = "0" + seconds;
				}else{
					seconds++;
				}
			}

			document.getElementById('clock').innerHTML = hours + ":" + minutes + ":" + seconds;
		}
		setInterval(function(){progressTime()}, 1000);
	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-50985585-2', 'auto');
	  ga('send', 'pageview');

	</script>
</head>
<body>
	<div id="wrapper">
		<div id="sidebar">
			<center><img src="/assets/images/logo-main.jpg" width="150" /></center>
			<table>
				<tr>
					<td><img src="<?php echo '../'.$thumbnail; ?>" width="50" style="border-radius:50px;" /></td>
					<td style="padding:5px;">
						<strong><a href="../profile.php?user=<?php echo $username; ?>" style="color:#FFF;"><?php echo $username; ?></a></strong><br />
						<span style="color:#ccc;">(<?php echo $status; ?>)</span>
					</td>
					<td style="text-align:right; width:100%; color:#a1a1a1; font-size:16px;">
						<?php require_once '../core/bootstrap.php'; echo '<a href="#" onclick="window.open(\'edit_user_entry.php?user_id='.$user_id.'\',\'\',\'scrollbars=no, toolbar=no, menubar=no, location=no, personalbar=no, resizable=no, directories=no, status=no, width=640, height=700\')"><i class="fa fa-cog" title="EDIT"></i></a>'; ?>
					</td>
				</tr>
			</table>
			<ul>
				<a href="/techblog/dashboard"><li id="dashboard-button"><i class="fa fa-home"></i> Dashboard</li></a>
				<a href="new_article.php"><li id="new-articles-button"><i class="fa fa-pencil"></i> Create Article</li></a>
				<a href="articles.php"><li id="articles-button"><i class="fa fa-file-text"></i> Articles</li></a>
				<?php
					if(adminUser($connection)){
					echo '
						<a href="users.php"><li id="users-button"><i class="fa fa-users"></i> Users</li></a>
						<a href="comments.php"><li id="comments-button"><i class="fa fa-comment"></i> Comments</li></a>
						';
					}
				?>

				<a href="/techblog"><li style="border-bottom:1px solid #252525;"><i class="fa fa-sign-out"></i> Logout</li></a>
			</ul>
			<center><div id="clock">Loading...</div></center>
		</div>