<?php
	include_once '../core/bootstrap.php';
	require_once 'counters.php';

	if(!loggedIn() || !adminUser()){
		if(!modUser()){
			header("Location: /techblog/index.php");
		}
	}

	include_once 'sidebar.php';

?>
		<script>
			document.getElementById('dashboard-button').style.color = "#fff";
			document.getElementById('dashboard-button').style.borderLeft = "1px solid #007be9";
		</script>
		<div id="main-content">
			<div class="h1">
				<table>
					<tr>
						<td>
							<i class="fa fa-home" style="font-size:60px;"></i>
						</td>
						<td>
							DASHBOARD
							<div style="font-size:13px;"><a href="/techblog/dashboard"><span style="color:#666;">HOME</span></a> / <span style="color:#777;">DASHBOARD</span></div>
						</td>
					</tr>
				</table>
				<?php
					if(adminUser()){
				?>
				<table style="margin-top:15px;">
					<tr>
						<td>
							<div class="stat-box" style="background-color:#3c8dbc;">
								<div class="stat-title">TOTAL ARTICLES</div>
								<div class="stat"><?php echo $total_post_count; ?></div>
								<div class="stat-icon"><strong><?php echo $posts_per_day; ?></strong> articles/day</div>
							</div>
						</td>
						<td>
							<div class="stat-box" style="background-color:#3c8dbc;">
								<div class="stat-title">TOTAL USERS</div>
								<div class="stat"><?php echo $overall_user_count; ?></div>
								<div class="stat-icon"><strong><?php echo $users_per_day; ?></strong> users/day</div>
							</div>
						</td>
						<td>
							<div class="stat-box" style="background-color:#3c8dbc;">
								<div class="stat-title">TOTAL COMMENTS</div>
								<div class="stat"><?php echo $overall_comment_count; ?></div>
								<div class="stat-icon"><strong><?php echo $comments_per_day; ?></strong> comments/day</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="stat-box" style="background-color:#00a65a;">
								<div class="stat-title">PUBLIC ARTICLES</div>
								<div class="stat"><?php echo $approved_post_count; ?></div>
								<div class="stat-icon"><strong><?php echo $public_post_percentage; ?></strong>%</div>
							</div>
						</td>
						<td>
							<div class="stat-box" style="background-color:#00a65a;">
								<div class="stat-title">ACTIVE USERS</div>
								<div class="stat"><?php echo $active_user_count; ?></div>
								<div class="stat-icon"><strong><?php echo $active_user_percentage; ?></strong>%</div>
							</div>
						</td>
						<td>
							<div class="stat-box" style="background-color:#00a65a;">
								<div class="stat-title">ACTIVE COMMENTS</div>
								<div class="stat"><?php echo $active_comment_count; ?></div>
								<div class="stat-icon"><strong><?php echo $active_comment_percentage; ?></strong>%</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="stat-box" style="background-color:#f56954;">
								<div class="stat-title">REJECTED ARTICLES</div>
								<div class="stat"><?php echo $rejected_post_count; ?></div>
								<div class="stat-icon"><strong><?php echo $rejected_post_percentage; ?></strong>%</div>
							</div>
						</td>
						<td>
							<div class="stat-box" style="background-color:#f56954;">
								<div class="stat-title">BLOCKED USERS</div>
								<div class="stat"><?php echo $unactive_user_count; ?></div>
								<div class="stat-icon"><strong><?php echo $unactive_user_percentage; ?></strong>%</div>
							</div>
						</td>
						<td>
							<div class="stat-box" style="background-color:#f56954;">
								<div class="stat-title">BLOCKED COMMENTS</div>
								<div class="stat"><?php echo $unactive_comment_count; ?></div>
								<div class="stat-icon"><strong><?php echo $unactive_comment_percentage; ?></strong>%</div>
							</div>
						</td>
					</tr>
				</table>
				<?php
					}else{
				?>
				<table style="margin-top:15px;">
					<tr>
						<td>
							<div class="stat-box" style="background-color:#3c8dbc;">
								<div class="stat-title">TOTAL ARTICLES</div>
								<div class="stat"><?php echo $user_total_post_count; ?></div>
							</div>
						</td>
						<td>
					<tr>
						<td>
							<div class="stat-box" style="background-color:#00a65a;">
								<div class="stat-title">PUBLIC ARTICLES</div>
								<div class="stat"><?php echo $user_approved_post_count; ?></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="stat-box" style="background-color:#f56954;">
								<div class="stat-title">REJECTED ARTICLES</div>
								<div class="stat"><?php echo $user_rejected_post_count; ?></div>
							</div>
						</td>
					</tr>
				</table>
				<?php
					}
				?>
			</div>
		</div>
		<div class="holder"></div>
	</div>
</body>
</html>