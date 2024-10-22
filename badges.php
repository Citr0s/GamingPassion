<?php
	include_once 'core/bootstrap.php';

	if(!loggedIn()){
		header("Location: /login.php?login-required");
	}

	include_once 'includes/header.php';
?>

<style>
	.badge-info{
		margin:5px 0px;
	}
	.badge-info img{
		margin:5px;
	}
	.badge-info h3{
		font:15px Arial;
		font-weight:bold;
	}
	.badge-info table{
		padding:5px;
		border-bottom:1px solid #cccccc;
		width:100%;
	}
</style>
		<div id="container">
			<div id="slideshow">
				<?php include_once 'includes/slideshow.php'; ?>
			</div>
			<div id="index-landing">
				<div id="main-content">
				<?php
					$username = $_SESSION['username'];
					$badge_count = 0;
					$overall_badge_count = 0;
					//Pasjonat - Ta odznaka nagradzamy uzytkownikow ktorzy dolaczyli do Gaming-Passion w pierwszym roku. Tak dziekujemy tym co pomogli stworzyc nasze spoleczenstwo pasjonatow gier komputerowych na Gaming-Passion.
					$user_data = mysqli_query($connection, "SELECT * FROM `users` WHERE username = '$username'");
					
					while($user_row = mysqli_fetch_array($user_data)){
						$joined = strtotime($user_row['joined']);
						$start_of_one_year = mktime(0, 0, 0, 4, 20, 2013);
						$end_of_one_year = mktime(0, 0, 0, 4, 20, 2014);
						$user_info = array($user_row['thumbnail'], $user_row['gender'], $user_row['home']);
						$status = $user_row['status'];
					}
					if($joined >= $start_of_one_year && $joined <= $end_of_one_year){
						$badge_pasjonat = true;
						$badge_count++;
						$overall_badge_count++;
					}else{
						$badge_pasjonat = false;
						$overall_badge_count++;
					}
					/** Alpha Tester **/
					$start_of_alpha = mktime(0, 0, 0, 4, 21, 2013);
					$end_of_alpha = mktime(0, 0, 0, 9, 1, 2013);
					if($joined <= $end_of_alpha){
						$badge_tester_alfa = true;
						$badge_count++;
						$overall_badge_count++;
					}else{
						$badge_tester_alfa = false;
						$overall_badge_count++;
					}
					/** Alpha Tester End**/
					
					/** Beta Tester **/
					$start_of_beta = mktime(0, 0, 0, 9, 1, 2013);
					$end_of_beta = mktime(0, 0, 0, 12, 31, 2013);
					if($joined <= $end_of_beta){
						$badge_tester_beta = true;
						$badge_count++;
						$overall_badge_count++;
					}else{
						$badge_tester_beta = false;
						$overall_badge_count++;
					}
					/** Beta Tester End**/
					
					/** Perfectionist **/
					if(!empty($user_info[0]) && $user_info[1] != 'unknown' && !empty($user_info[1]) && !empty($user_info[2])){
						$badge_perfekcjonista = true;
						$badge_count++;
						$overall_badge_count++;
					}else{
						$badge_perfekcjonista = false;
						$overall_badge_count++;
					}	
					/** Perfectionist End **/
					
					//Poczatkujacy Komentator - Po raz pierwszy skomentowales jakiegos posta.
					$user_data = mysqli_query($connection, "SELECT * FROM `comments` WHERE `comment_author` = '$username' AND `active` = 1");
					$comment_count = 0;
					$badge_komentator_1 = false;
					$badge_komentator_10 = false;
					$badge_komentator_100 = false;
					$badge_mailman = false;
					$overall_badge_count += 4;
					
					while($user_row = mysqli_fetch_array($user_data)){
						$comment_count++;
					}
					
					/** Judge Start **/

					$data = mysqli_query($connection, "SELECT * FROM `ratings` WHERE author = '$username'");
					$ratings_count = 0;
					$badge_judge = false;
					$badge_judge_10 = false;
					$badge_judge_100 = false;
					$overall_badge_count += 3;
					
					while($row = mysqli_fetch_array($data)){
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

					$comment_percentage_1 = ($comment_count / 1) * 100;
					$comment_percentage_10 = ($comment_count / 10) * 100;
					$comment_percentage_100 = ($comment_count / 100) * 100;

					$badge_percentage_1 = ($ratings_count / 1) * 100;
					$badge_percentage_10 = ($ratings_count / 10) * 100;
					$badge_percentage_100 = ($ratings_count / 100) * 100;

					if($comment_count < 1){
						$progress_bar_1 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($comment_percentage_1, 1).'%;"></div></div> ('.$comment_count.'/1)';
						$progress_bar_2 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($comment_percentage_10, 1).'%;"></div></div> ('.$comment_count.'/10)';
						$progress_bar_3 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($comment_percentage_100, 1).'%;"></div></div> ('.$comment_count.'/100)';
					}elseif($comment_count >= 1 && $comment_count < 10){
						$progress_bar_1 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (1/1)';
						$progress_bar_2 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($comment_percentage_10, 1).'%;"></div></div> ('.$comment_count.'/10)';
						$progress_bar_3 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($comment_percentage_100, 1).'%;"></div></div> ('.$comment_count.'/100)';
					}elseif($comment_count >= 1 && $comment_count >= 10 && $comment_count <= 100){
						$progress_bar_1 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (1/1)';
						$progress_bar_2 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (10/10)';
						$progress_bar_3 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($comment_percentage_100, 1).'%;"></div></div> ('.$comment_count.'/100)';
					}elseif($comment_count >= 100){
						$progress_bar_1 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (1/1)';
						$progress_bar_2 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (10/10)';
						$progress_bar_3 = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> ('.$comment_count.'/100)';
					}

					if($ratings_count < 1){
						$progress_bar_1_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($badge_percentage_1, 1).'%;"></div></div> ('.$ratings_count.'/1)';
						$progress_bar_2_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($badge_percentage_10, 1).'%;"></div></div> ('.$ratings_count.'/10)';
						$progress_bar_3_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($badge_percentage_100, 1).'%;"></div></div> ('.$ratings_count.'/100)';
					}elseif($ratings_count >= 1 && $ratings_count < 10){
						$progress_bar_1_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (1/1)';
						$progress_bar_2_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($badge_percentage_10, 1).'%;"></div></div> ('.$ratings_count.'/10)';
						$progress_bar_3_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($badge_percentage_100, 1).'%;"></div></div> ('.$ratings_count.'/100)';
					}elseif($ratings_count >= 1 && $ratings_count >= 10 && $ratings_count <= 100){
						$progress_bar_1_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (1/1)';
						$progress_bar_2_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (10/10)';
						$progress_bar_3_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:'.round($badge_percentage_100, 1).'%;"></div></div> ('.$ratings_count.'/100)';
					}elseif($ratings_count >= 100){
						$progress_bar_1_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (1/1)';
						$progress_bar_2_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> (10/10)';
						$progress_bar_3_judge = '<div class="small-badge-progress-bar-frame"><div class="small-badge-progress-bar" style="width:100%;"></div></div> ('.$ratings_count.'/100)';
					}
					
					
					$data2b = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `from` = '$username'");
					$mail_count = 0;
					
					while($row2b = mysqli_fetch_array($data2b)){
						$mail_count++;
					}

					if($mail_count >= 1){
						$badge_mailman = true;
						$badge_count++;			
					}
					
					$percentage_collected = ($badge_count / $overall_badge_count) * 100;
				?>        
			<p>
				<strong>You are here:</strong> <a href="index.php">HOME</a> > <a href="/profile.php?user=<?php echo $username; ?>">MY PROFILE</a> > <a href="/badges.php">BADGES</a>
			</p>
			<div id="badges-container">
        	<h1>BADGES</h1><br />

        	<p>Overall Progress (<?php echo round($percentage_collected, 1); ?>%)</p>
		<?php
		//Special Badges
		//DONE//created an account between 21/04/2013 and 12/04/2014 - Pasjonat
		//DONE//created an acount while the website was in alpha state - Tester Alfa // for later
		//DONE//created an acount while the website was in beta state - Tester Beta // for later
		
		//Normal badges
		//DONE//made one comment on any post // - Poczatkujacy Komentator - 1
		//DONE//made ten comment on any post // - Srednio Zaawansowany Komentator - 10
		//DONE//made hundred comment on any post // - Wielki Komentator - 100
		//DONE//completed their profile information // for later
        
        ?>
        	<div class="badge-progress-bar-frame"><div class="badge-progress-bar" style="width:<?php echo round($percentage_collected, 1); ?>%;"><?php echo round($percentage_collected, 1); ?>%</div></div>
            <p style="padding-bottom:0px;">You have <strong><?php echo $badge_count ?></strong> out of <strong><?php echo $overall_badge_count; ?></strong> badges. (<?php echo round($percentage_collected, 1); ?>%)</p>
            <div class="badge-info">
            <table style="border-bottom:none; width:auto;">
            	<tr>
		<?php
			if($badge_tester_alfa == true){
				echo '<td><a title="Alpha Tester - With this badge we are thanking the users who joined our site in the Alpha Phase and helped testing it."><img src="assets/images/badges/badge_tester_alfa_unlocked.jpg" height="50" width="50" /></a></td>';
			}
			if($badge_tester_beta == true){
				echo '<td><a title="Beta Tester - With this badge we are thanking the users who joined our site in the Beta Phase and helped testing it."><img src="assets/images/badges/badge_tester_beta_unlocked.jpg" height="50" width="50" /></a></td>';
			}
            if($badge_pasjonat == true){
				echo '<td><a title="Passionate - With this badge we are thanking the users who joined our site in the first year of our existance. This is how we thank people who helped shape our community."><img src="assets/images/badges/badge_pasjonat_unlocked.jpg" height="50" width="50" /></a></td>';
			}
			if($badge_perfekcjonista == true){
				echo '<td><a title="Perfectionist - Fully completed the profile information."><img src="assets/images/badges/badge_profile_complete_unlocked.jpg" height="50" width="50" /></a></td>';
			}
			if($badge_komentator_1 == true){
				echo '<td><a title="Student Commentator - Commented for the first time."><img src="assets/images/badges/badge_komentator_1_unlocked.jpg" height="50" width="50" /><a></td>';
			}
			if($badge_komentator_10 == true){
				echo '<td><a title="Master Commentator - You commented 10 times!"><img src="assets/images/badges/badge_komentator_10_unlocked.jpg" height="50" width="50" /></a></td>';
			}
			if($badge_komentator_100 == true){
				echo '<td><a title="Ninja Commentator - You commented 100 times!"><img src="assets/images/badges/badge_komentator_100_unlocked.jpg" height="50" width="50" /></a></td>';
			}
			if($badge_mailman == true){
				echo '<td><a title="Whisperer - Send your first private message."><img src="assets/images/badges/badge_first_mail_unlocked.gif" height="50" width="50" /></a></td>';
			}
			if($badge_judge == true){
				echo '<td><a title="Judge - Rate at least 1 post."><img src="assets/images/badges/badge_judge_unlocked.png" height="50" width="50" /></a></td>';
			}
			if($badge_judge_10 == true){
				echo '<td><a title="Master Commentator - You commented 10 times!"><img src="assets/images/badges/badge_judge_10_unlocked.jpg" height="50" width="50" /></a></td>';
			}
			if($badge_judge_100 == true){
				echo '<td><a title="Ninja Commentator - You commented 100 times!"><img src="assets/images/badges/badge_judge_100_unlocked.jpg" height="50" width="50" /></a></td>';
			}
		?>
        		</tr>
			</table>
            </div>
            <h2>Other Badges</h2>
<?php
			if($badge_perfekcjonista == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_profile_complete_unlocked.jpg" height="50" width="50" /></td><td><h3>Perfectionist</h3><p>Fully completed the profile information.</td></tr></table></div>';
			}if($badge_perfekcjonista == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_profile_complete_locked.jpg" height="50" width="50" /></td><td><h3>Perfectionist</h3><p>Fully completed the profile information.</td></tr></table></div>';
			}			
			if($badge_komentator_1 == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_komentator_1_unlocked.jpg" height="50" width="50" /></td><td><h3>Student Commentator</h3><p>Commented for the first time.</p>'.$progress_bar_1.'</td></tr></table></div>';
			}if($badge_komentator_1 == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_komentator_1_locked.jpg" height="50" width="50" /></td><td><h3>Student Commentator</h3><p>Commented for the first time.'.$progress_bar_1.'</td></tr></table></div>';
			}
			if($badge_komentator_10 == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_komentator_10_unlocked.jpg" height="50" width="50" /></td><td><h3>Master Commentator</h3><p>You commented 10 times!'.$progress_bar_2.'</p></td></tr></table></div>';
			}if($badge_komentator_10 == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_komentator_10_locked.jpg" height="50" width="50" /></td><td><h3>Master Commentator</h3><p>You commented 10 times!'.$progress_bar_2.'</td></tr></table></div>';
			}
			if($badge_komentator_100 == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_komentator_100_unlocked.jpg" height="50" width="50" /></td><td><h3>Ninja Commentator</h3><p>You commented 100 times!'.$progress_bar_3.'</p></td></tr></table></div>';
			}if($badge_komentator_100 == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_komentator_100_locked.jpg" height="50" width="50" /></td><td><h3>Ninja Commentator</h3><p>You commented 100 times!'.$progress_bar_3.'</td></tr></table></div>';
			}
			if($badge_mailman == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_first_mail_unlocked.gif" height="50" width="50" /></td><td><h3>Whisperer</h3><p>Send your first private message.</td></tr></table></div>';
			}if($badge_mailman == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_first_mail_locked.gif" height="50" width="50" /></td><td><h3>Whisperer</h3><p>Send your first private message.</td></tr></table></div>';
			}
			if($badge_judge == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_judge_unlocked.png" height="50" width="50" /></td><td><h3>Judge</h3><p>Rate at least 1 post.'.$progress_bar_1_judge.'</p></td></tr></table></div>';
			}if($badge_judge == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_judge_locked.png" height="50" width="50" /></td><td><h3>Judge</h3><p>Rate at least 1 post.'.$progress_bar_1_judge.'</p></td></tr></table></div>';
			}
			if($badge_komentator_10 == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_judge_10_unlocked.jpg" height="50" width="50" /></td><td><h3>Student Judge</h3><p>You judged 10 times!'.$progress_bar_2_judge.'</p></td></tr></table></div>';
			}if($badge_judge_10 == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_judge_10_locked.jpg" height="50" width="50" /></td><td><h3>Student Judge</h3><p>You judged 10 times!'.$progress_bar_2_judge.'</td></tr></table></div>';
			}
			if($badge_judge_100 == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_judge_100_unlocked.jpg" height="50" width="50" /></td><td><h3>Master Judge</h3><p>You judged 100 times!'.$progress_bar_3_judge.'</p></td></tr></table></div>';
			}if($badge_judge_100 == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_judge_100_locked.jpg" height="50" width="50" /></td><td><h3>Master Judge</h3><p>You judged 100 times!'.$progress_bar_3_judge.'</td></tr></table></div>';
			}
		?>
            <br /><h2>Special Badges</h2>
		<?php
			if($badge_pasjonat == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_pasjonat_unlocked.jpg" height="50" width="50" /></td><td><h3>Passionate</h3><p>With this badge we are thanking the users who joined our site in the first year of our existance. This is how we thank people who helped shape our community.</p></td></tr></table></div>';
			}if($badge_pasjonat == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_pasjonat_locked.jpg" height="50" width="50" /></td><td><h3>Passionate</h3><p>With this badge we are thanking the users who joined our site in the first year of our existance. This is how we thank people who helped shape our community.</td></tr></table></div>';
			}
			if($badge_tester_alfa == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_tester_alfa_unlocked.jpg" height="50" width="50" /></td><td><h3>Alpha Tester</h3><p>With this badge we are thanking the users who joined our site in the Alpha Phase and helped testing it.</p></td></tr></table></div>';
			}if($badge_tester_alfa == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_tester_alfa_locked.jpg" height="50" width="50" /></td><td><h3>Alpha Tester</h3><p>With this badge we are thanking the users who joined our site in the Alpha Phase and helped testing it.</td></tr></table></div>';
			}
			if($badge_tester_beta == true){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_tester_beta_unlocked.jpg" height="50" width="50" /></td><td><h3>Beta Tester</h3><p>With this badge we are thanking the users who joined our site in the Beta Phase and helped testing it.</p></td></tr></table></div>';
			}if($badge_tester_beta == false){
				echo '<div class="badge-info"><table><tr><td width="60"><img src="assets/images/badges/badge_tester_beta_locked.jpg" height="50" width="50" /></td><td><h3>Beta Tester</h3><p>With this badge we are thanking the users who joined our site in the Beta Phase and helped testing it.</td></tr></table></div>';
			}
		?>
		</div>
				</div>
				<?php include_once 'includes/sidebar.php'; ?>
			</div>
		</div>
<?php
	include_once 'includes/footer.php';
?>