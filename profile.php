<?php
	include_once 'core/init.php';

	if(!isset($_GET['user'])){
		header('Location: index.php');
		die();
	}

	include_once 'includes/header.php';
?>
		<div id="container">
			<div id="slideshow">
				<?php include_once 'includes/slideshow.php'; ?>
			</div>
			<div id="index-landing">
				<div id="main-content">
				<?php
					$user = $_GET['user'];
				
					$data = mysqli_query($connection, "SELECT * FROM `users` WHERE '$user' = username");
					
					$comment_count = 0;
				
					while($row = mysqli_fetch_array($data)){
						$active = $row['active'];
						$thumbnail = $row['thumbnail'];
						$email = $row['email'];
						$user_info = array($row['thumbnail'], $row['gender'], $row['home']);
						$joined = strtotime($row['joined']);
						$gender = $row['gender'];
						$start_of_one_year = mktime(0, 0, 0, 4, 20, 2013);
						$end_of_one_year = mktime(0, 0, 0, 4, 20, 2014);
						$from = $row['home'];
						$status = $row['status'];
						
						
						if(empty($thumbnail)){
							$thumbnail = 'css/images/image-missing.jpg';	
						}
						if(empty($email)){
							$email = ' - ';	
						}
						
						if(empty($gender)){
							$gender = ' - ';	
						}elseif($gender == 'male'){
							$gender = 'Male';	
						}elseif($gender == 'female'){
							$gender = 'Female';	
						}elseif($gender == 'unknown'){
							$gender = ' - ';
						}
						
						if(empty($from)){
							$from = ' - ';	
						}
						
						$data2a = mysqli_query($connection, "SELECT * FROM `comments` WHERE `comment_author` = '$user' AND `active` = 1 ORDER BY `comment_id`");
						$post_count = 0;
						$comment_count = 0;
						$badge_komentator_1 = false;
						$badge_komentator_10 = false;
						$badge_komentator_100 = false;
						$badge_mailman = false;
						$badge_count = 0;
						
						while($row2a = mysqli_fetch_array($data2a)){
							$comment_count++;
						}
						
						$data2b = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `from` = '$user'");
						$mail_count = 0;
						
						while($row2b = mysqli_fetch_array($data2b)){
							$mail_count++;
						}
						
						/** Badges Start **/
						if($joined >= $start_of_one_year && $joined <= $end_of_one_year){
							$badge_pasjonat = true;
							$badge_count++;
						}else{
							$badge_pasjonat = false;
						}
						/** Alpha Tester **/
						$start_of_alpha = mktime(0, 0, 0, 4, 21, 2013);
						$end_of_alpha = mktime(0, 0, 0, 9, 1, 2013);
						if($joined <= $end_of_alpha){
							$badge_tester_alfa = true;
							$badge_count++;
						}else{
							$badge_tester_alfa = false;
						}
						/** Alpha Tester End**/
						
						/** Beta Tester **/
						$start_of_beta = mktime(0, 0, 0, 9, 1, 2013);
						$end_of_beta = mktime(0, 0, 0, 12, 31, 2013);
						if($joined <= $end_of_beta){
							$badge_tester_beta = true;
							$badge_count++;
						}else{
							$badge_tester_beta = false;
						}
						/** Beta Tester End**/
							
						/** Perfectionist **/
						if(!empty($user_info[0]) && $user_info[1] != 'unknown' && !empty($user_info[1]) && !empty($user_info[2])){
							$badge_perfekcjonista = true;
							$badge_count++;
						}else{
							$badge_perfekcjonista = false;		
						}	
						/** Perfectionist End **/

						/** Judge Start **/

						$data2 = mysqli_query($connection, "SELECT * FROM `ratings` WHERE author = '$user'");
						$ratings_count = 0;
						$badge_judge = false;
						$badge_judge_10 = false;
						$badge_judge_100 = false;
						$overall_badge_count += 3;
						
						while($row2 = mysqli_fetch_array($data2)){
							$ratings_count++;
						}
						/*
						if($status == 'admin'){
							$comment_count += 100;
						}
						if($status == 'admin'){
							$ratings_count += 100;
						}
						*/
						/** Judge End **/

						if($comment_count >= 1){
							$badge_komentator_1 = true;
							$badge_count++;			
						}
						
						if($comment_count >= 10){
							$badge_komentator_10 = true;
							$badge_count++;
						}
						if($comment_count >= 100){
							$badge_komentator_100 = true;
							$badge_count++;
						}

						if($mail_count >= 1){
							$badge_mailman = true;
							$badge_count++;			
						}

						if($ratings_count >= 1){
							$badge_judge = true;
							$badge_count++;
						}
						if($ratings_count >= 10){
							$badge_judge_10 = true;
							$badge_count++;
						}
						if($ratings_count >= 100){
							$badge_judge_100 = true;
							$badge_count++;
						}

						/** Badges End **/
						
						if($comment_count <= 5){
							$user_title = 'Student Commentator';
						}elseif($comment_count >= 10 && $comment_count < 20){
							$user_title = 'Master Commentator';
						}elseif($comment_count >= 20 && $comment_count < 50){
							$user_title = 'Ninja Commentator';
						}elseif($comment_count >= 50 && $comment_count < 100){
							$user_title = 'King Commentator';
						}elseif($comment_count >= 100){
							$user_title = 'Gandalf';
						}
						
						$joined = strtotime($row['joined']);
						$today = time();
						
						$time_with_us = ($today - $joined)/86400;
						$time_with_us = intval($time_with_us);
				
						$days = $time_with_us;
						$years = 0;
						
						while($days >= 365){
							$years++;
							
							$days = $days - 365;
						}
						
						if($days == 1){
							$days = $days.' day ';
						}else{
							$days = $days.' days ';
						}
						
						if($years == 1){
							$years = $years.' year ';
						}elseif($years > 1){
							$years = $years.' years ';	
						}else{
							$years = '';			
						}

						$age = strtotime($row['birthday']);
						$today = time();
						
						$time_alive = ($today - $age)/86400;
						$time_alive = intval($time_alive);
				
						$days2 = $time_alive;
						$years2 = 0;
						
						while($days2 >= 365){
							$years2++;
							
							$days2 = $days2 - 365;
						}
						
						if($years2 == 44){
							$years2 = ' - ';	
						}
						
						$comment_data2 = mysqli_query($connection, "SELECT * FROM `comments` WHERE `comment_author` = '$user' AND `active` = 1 ORDER BY `comment_id` LIMIT 1");
						
						while($comment_row2 = mysqli_fetch_array($comment_data2)){
							$first_comment = $comment_row2['timestamp'];
						}
						
						$data = mysqli_query($connection, "SELECT * FROM `posts` WHERE '$user' = `post_author` AND `public` = 1");
						$post_count = 0;
						while($row2 = mysqli_fetch_array($data)){
							$post_count++;
						}
						
						$first_comment = strtotime($first_comment);
						$time_from_last_comment = (($today - $first_comment) / 86400);
						$time_from_last_comment = intval($time_from_last_comment);
						$comments_per_day = $comment_count / $time_from_last_comment;
						$comments_per_day = round($comments_per_day, 2);
						if($active == 1){
						echo '
								<div id="main-content">
									<p style="margin-bottom:10px;">
										<strong>You are here:</strong> <a href="index.php">HOME</a> > <a href="profile.php?user='.$user.'">'; if($user == $_SESSION['username']){echo 'MY PROFILE';}else{ echo $user; } echo '</a>
									</p>
									<div id="user-info-sidebar">
										<div class="user-info-sidebar-block">
												<center><img src="'.$thumbnail.'" width="200" height="200" /><br /></center>
											<h3>'.$_GET['user'].'</h3>';
											
											if($_GET['user'] == $_SESSION['username']){
													echo '<p><a href="edit.php?user='.$_GET['user'].'">Edit Profile</a></p><br />';
											}
							
						echo '
											<p>Sex: <strong>'.$gender.'</strong></p>
											<p>From: <strong>'.$from.'</strong></p>
										</div>
										<div class="user-info-sidebar-block">
											<h4>Info</h4>
											<p>Status: <span '; if($status == 'admin'){echo 'class="status-info-admin"';}elseif($status == 'mod'){echo 'class="status-info-mod"';}else{echo 'class="status-info-user"';} echo '>'.strtoupper($status).'</span></p>
											<p>Title: <strong>'.$user_title.'</strong></p>
										</div>
											<div class="user-info-sidebar-block">
												<span style="float:left;"><h4>Badges ('.$badge_count.')</h4></span> <span style="float:right;"><a href="badges.php" title="Show all badges.">(?)</a></span><div class="holder"></div>';?>
												<div style="width:auto;">
											<?php
												if($badge_tester_alfa == true){
													echo '<div class="badge"><a title="Alpha Tester - With this badge we are thanking the users who joined our site in the Alpha Phase and helped testing it."><img src="css/images/badges/badge_tester_alfa_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_tester_beta == true){
													echo '<div class="badge"><a title="Beta Tester - With this badge we are thanking the users who joined our site in the Beta Phase and helped testing it."><img src="css/images/badges/badge_tester_beta_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_pasjonat == true){
													echo '<div class="badge"><a title="Passionate - With this badge we are thanking the users who joined our site in the first year of our existance. This is how we thank people who helped shape our community."><img src="css/images/badges/badge_pasjonat_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_perfekcjonista == true){
													echo '<div class="badge"><a title="Perfectionist - Fully completed the profile information."><img src="css/images/badges/badge_profile_complete_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_komentator_1 == true){
													echo '<div class="badge"><a title="Student Commentator - Commented for the first time."><img src="css/images/badges/badge_komentator_1_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_komentator_10 == true){
													echo '<div class="badge"><a title="Master Commentator - You commented 10 times!"><img src="css/images/badges/badge_komentator_10_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_komentator_100 == true){
													echo '<div class="badge"><a title="Ninja Commentator - You commented 100 times!"><img src="css/images/badges/badge_komentator_100_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_mailman == true){
													echo '<div class="badge"><a title="Whisperer - Send your first private message."><img src="css/images/badges/badge_first_mail_unlocked.gif" height="25" width="25" /></a></div>';
												}
												if($badge_judge == true){
													echo '<div class="badge"><a title="Judge - Rate at least 1 post."><img src="css/images/badges/badge_judge_unlocked.png" height="25" width="25" /></a></div>';
												}
												if($badge_judge_10 == true){
													echo '<div class="badge"><a title="Student Judge - You juged 10 times!"><img src="css/images/badges/badge_judge_10_unlocked.jpg" height="25" width="25" /></a></div>';
												}
												if($badge_judge_100 == true){
													echo '<div class="badge"><a title="Master Judge - You juged 100 times!"><img src="css/images/badges/badge_judge_100_unlocked.jpg" height="25" width="25" /></a></div>';
												}
											?>
												<div class="holder"></div>
												</div>
												
				<?php			echo '		</div>
											<div class="user-info-sidebar-block">
												<h4>Stats</h4>
												<p>With us since: <strong>'.$years.' '.$days.'</strong></p>';
												if($status == 'admin' || $status == 'mod'){echo '<p>Posts: <strong>'.$post_count.'</strong></p>';}
								echo '			
												<p>Comments: <strong>'.$comment_count.'</strong></p>
												<p>Comments/Day: <strong>'.$comments_per_day.'</strong></p>
											</div>
										</div>
										<div id="user-info-list">';
										if($status == 'admin' || $status == 'mod'){
										
								echo '		<div class="green-message-profile">
												<h3>POSTS ('.$post_count.')</h3>
											</div>
								';
											$post_data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_author` = '$user' AND `public` = 1 ORDER BY `post_id` DESC");
											$post_count = 0;
											while($post_row = mysqli_fetch_array($post_data)){
												$timestamp = strtotime($post_row['timestamp']);
												$date =  date('d/m/Y', $timestamp);
												$time = date('G:i', $timestamp);
												$post_id = $post_row['post_id'];
												$post_title = $post_row['post_title'];
												$post_author = $post_row['post_author'];
												$post_content = htmlentities($post_row['post_content'], ENT_QUOTES, 'UTF-8');
												$public = $post_row['public'];
												$post_thumbnail = $post_row['thumbnail'];
										
												if(empty($thumbnail)){
													$thumbnail = 'css/images/image-missing.png';	
												}

												echo '
												<div class="post-comment" style="border:none; border-radius:0px;">
													<div class="post-small" style="padding:5px 0px;">
														<a href="index.php?id='.$post_id.'">
															<h3 style="margin-bottom:5px;">'.strtoupper($post_title).'</h3>
														</a>
														<div>
														<a href="index.php?id='.$post_id.'">
															<div class="post-image-small"><img src="'.$post_thumbnail.'" /></div>
														</a>
														</div>
														<p>
															'.substr($post_content, 0,152).'...
															<div class="holder"></div>
															<div class="float-right" style="padding-top:5px;">
																<a href="index.php?id='.$post_id.'">
																	<strong>(Read the Full Article)</strong>
																</a>
															</div>
															<div class="holder"></div>
														</p>
													</div>
												</div>
												';
												$post_count++;
											}
											if($post_count == 0 ){
												echo '
													<center><div class="empty_result">Currently you don\'t have any posts.</div></center>';
													
											}
										}
								echo '
											<div class="green-message-profile">
												<h3>COMMENTS ('.$comment_count.')</h3>
											</div>
								';
											$comment_data = mysqli_query($connection, "SELECT * FROM `comments` WHERE comment_author = '$user'  AND `active` = 1 ORDER BY comment_id DESC");
											$comment_count = 0;
											while($comment_row = mysqli_fetch_array($comment_data)){
												$timestamp = strtotime($comment_row['timestamp']);
												$date =  date('d/m/Y', $timestamp);
												$time = date('G:i', $timestamp);
												$comment_count++;
												$comment_post_id = $comment_row['comment_post_id'];
												
												$post_data = mysqli_query($connection, "SELECT * FROM `posts` WHERE post_id = $comment_post_id");
												
												while($post_row = mysqli_fetch_array($post_data)){
													$post_id = $post_row['post_id'];
													$post_title = $post_row['post_title'];
													break;
												}
												
												if($comment_row['comment_author_status'] == 'admin'){
													$color = 'red';
												}elseif($comment_row['comment_author_status'] == 'mod'){
													$color = 'blue';
												}elseif($comment_row['comment_author_status'] == 'user'){
													$color = '#333';
												}else{
													$color = '#333';	
												}
												echo '
												<div class="post-comment">
													<i><strong><span style="color:'.$color.';">'.$comment_row['comment_author'].'</span></strong> at <strong>'.$time.'</strong> on <strong>'.$date.'</strong> under the post <a href="index.php?id='.$post_id.'"><strong>'.substr($post_title, 0, 25).'</strong></a></i><br /><br />
													<span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">"'.$comment_row['comment_content'].'"</span>
												</div>';
											}
											if($comment_count == 0 ){
												echo '
													<center><div class="empty_result">Currently you don\'t have any comments.</div></center>
													';
											}
								echo '
										</div>
										<div class="holder"></div>
									</div>
								';
						}else{
								echo '
									<div id="main-content">
										<center><div class="empty_result">This user has been blocked.</div></center>
									</div>
								';			
						}
					}
				?>
				</div>
				<?php
					if($_GET['user'] == $_SESSION['username']){
						echo '
							<div id="sidebar-messages">
								<h3>PRIVATE MESSAGES</h3>
								<a href="messages.php"><div class="profile-sidebar-li">INBOX</div></a>';
								receivedMessages();
						echo '
								<a href="messages.php#sent"><div class="profile-sidebar-li">SENT</div></a>';
								sentMessages();
						echo '
								<a href="messages.php#compose"><div class="profile-sidebar-special">CREATE</div></a>
							</div>
            				<div class="holder"></div>
							';
					}else{
						include 'includes/sidebar.php';
					}
				?>
			</div>
		</div>
<?php
	include_once 'includes/footer.php';
?>