		<div id="footer">
			<div class="footer-container">
				<table style="margin-bottom:20px;">
					<tr>
						<td>
							<ul>
								<li>
									<div class="footer-heading">Information</div>
								</li>
								<li>
									<a href="">About us</a>
								</li>
								<li>
									<a href="">Customer Service</a>
								</li>
								<li>
									<a href="">Template Settings</a>
								</li>
								<li>
									<a href="">Privacy Policy</a>
								</li>
								<li>
									<a href="">Site Map</a>
								</li>
								<li>
									<a href="">Search Terms</a>
								</li>
								<li>
									<a href="">Advanced Search</a>
								</li>
								<li>
									<a href="">Orders and Returns</a>
								</li>
								<li>
									<a href="">Contact Us</a>
								</li>
							</ul>
						</td>
						<td>
						<?php
							if(isset($_SESSION['username'])){
								echo '
									<ul>
										<li>
											<div class="footer-heading">My account</div>
										</li>
										<li>
											<a href="profile.php?user='.$_SESSION['username'].'">My Profile</a>
										</li>
										<li>
											<a href="messages.php">Private Messages</a>
										</li>
										<li>
											<a href="badges.php">Badges</a>
										</li>
										<li>
											<a href="logout.php">Logout</a>
										</li>
									</ul>
								';
							}else{
								echo '
									<ul>
										<li>
											<div class="footer-heading">My account</div>
										</li>
										<li>
											<a href="/login.php">Login</a>
										</li>
										<li>
											<a href="/register.php">Register</a>
										</li>
										<li>
											<a href="/login.php">Private Messages</a>
										</li>
										<li>
											<a href="/login.php">Badges</a>
										</li>
									</ul>
								';
							}
						?>
						</td>
						<td>
							<ul>
								<li>
									<div class="footer-heading" style="width:70px;">Follow us!</div>
								</li>
								<li>
									<a href="https://www.facebook.com/GamingPassionPL">Facebook</a>
								</li>
								<li>
									<a href="https://twitter.com/GamingPassionPL">Twitter</a>
								</li>
								<li>
									<a href="https://www.youtube.com/user/GamingPassionPL/">YouTube</a>
								</li>
								<li>
									<a href="mailto:gamingpassionpl@gmail.com">Email</a>
								</li>
							</ul>
						</td>
						<td style="padding-right:0px; padding-left:190px;">
							<img src="assets/images/logo-main.jpg" alt="gaming passion logo" />
						</td>
					</tr>
				</table>
				<div style="font-size:11px; margin-bottom:20px;">&copy; 2013 - 2014 <a href="https://www.gaming-passion.com/">Gaming Passion.</a> All Rights Reserved.<br />Designed and Developed by <a href="http://www.miloszdura.com/">Milosz Dura</a></div>
			</div>
		</div>
	</div>
</body>
</html>