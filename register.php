<?php
	include_once 'core/bootstrap.php';

	if(loggedIn()){
		header("Location: /");
		die();
	}

	include_once 'includes/header.php';
?>
	<div id="container">
		<div id="full-width-container">
			<h2>LOGIN</h2>
		</div>
		<div class="container">
			<div class="loginbox" style="background-image:url(assets/images/login-box-bg.gif); width:990px;">
				<h3>NEW USER</h3>
				<p>Please register using the form below.</p>
				<?php registerErrors(); ?>
				<?php
					if(isset($_GET['success'])){
						echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>You have been successfully <strong>registered</strong>.</td></tr></table></div>';
					}
				?>
				<form action="register-check.php" method="post">
					<table>
						<tr>
							<td style="padding-bottom:5px;">
								<strong>Username:</strong><span class="green-text">*</span>
							</td>
						</tr>
						<tr>
							<td>
								<input type="username" name="username" id="login" />
							</td>
						</tr>
						<tr>
							<td style="padding-bottom:5px;">
								<strong>Email Address:</strong><span class="green-text">*</span>
							</td>
						</tr>
						<tr>
							<td>
								<input type="email" name="email" id="login" />
							</td>
						</tr>
						<tr>
							<td style="padding-bottom:5px;">
								<strong>Password:</strong><span class="green-text">*</span>
							</td>
							<td style="padding-bottom:5px;">
								<strong>Confirm Password:</strong><span class="green-text">*</span>
							</td>
						</tr>
						<tr>
							<td>
								<input type="password" name="password" />
							</td>
							<td>
								<input type="password" name="password_check" />
							</td>
						</tr>
						<tr>
							<td align="center">
								<div class="g-recaptcha" data-sitekey="6LeXsf4SAAAAAF8YxjHnQw3VYqZPF9BQ79QR4osg"></div>
							</td>
						</tr>
						<tr>
							<td>
								<button class="button" type="submit" style="padding:10px 15px;">Register</button>
								<span class="red-text" style="margin-left:15px;">* Required Fields</span>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="holder"></div>
		</div>
	</div>
<?php
	include_once 'includes/footer.php';
?>