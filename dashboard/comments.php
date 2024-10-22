<?php
	include_once '../core/bootstrap.php';
	require_once 'counters.php';

	if(!loggedIn() || !adminUser($connection)){
		if(!modUser($connection)){
			header("Location: /");
		}
	}

	include_once 'sidebar.php';

?>
		<script>
			document.getElementById('comments-button').style.color = "#fff";
			document.getElementById('comments-button').style.borderLeft = "1px solid #007be9";
		</script>
		<div id="main-content">
			<div class="h1">
				<table>
					<tr>
						<td>
							<i class="fa fa-comment" style="font-size:60px; margin-right:10px;"></i>
						</td>
						<td>
							COMMENTS
							<div style="font-size:13px;"><a href="/techblog/dashboard"><span style="color:#666;">HOME</span></a> / <span style="color:#777;">COMMENTS</span></div>
						</td>
					</tr>
				</table>
					<div id="postContaiener" style="margin-top:15px;">
						<?php showAllCommentsDashboard($connection); ?>
						<div class="holder"></div>
					</div>
			</div>
		</div>
		<div class="holder"></div>
	</div>
</body>
</html>