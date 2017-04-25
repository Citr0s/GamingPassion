<?php
	include_once '../core/bootstrap.php';
	require_once 'counters.php';

	if(!loggedIn() || !adminUser()){
		header("Location: /techblog/index.php");
	}

	include_once 'sidebar.php';

?>
		<script>
			document.getElementById('users-button').style.color = "#fff";
			document.getElementById('users-button').style.borderLeft = "1px solid #007be9";
		</script>
		<div id="main-content">
			<div class="h1">
				<table>
					<tr>
						<td>
							<i class="fa fa-users" style="font-size:60px; margin-right:10px;"></i>
						</td>
						<td>
							USERS
							<div style="font-size:13px;"><a href="/techblog/dashboard"><span style="color:#666;">HOME</span></a> / <span style="color:#777;">USERS</span></div>
						</td>
					</tr>
				</table>
					<div id="postContaiener" style="margin-top:15px;">
						<?php showAllUsersDashboard(); ?>
						<div class="holder"></div>
					</div>
			</div>
		</div>
		<div class="holder"></div>
	</div>
</body>
</html>