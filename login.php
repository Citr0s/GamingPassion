<?php
	include_once 'core/bootstrap.php';

	if(loggedIn()){
		header("Location: index.php");
		die();
	}

	include_once 'includes/header.php';
?>
	<div id="container">
		<div id="full-width-container">
			<h2>LOGIN</h2>
		</div>
		<div class="container">
			<div class="loginbox" style="margin-right:15px; background-image:url(css/images/register-box-bg.gif);">
				<h3>NEW USER</h3>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat delectus perferendis, et, corrupti iure quas veritatis similique vitae, dignissimos in iusto facilis nesciunt quis eveniet dolores reprehenderit optio! Delectus, facere?
					<a href="register.php"><button class="button" style="padding:10px; margin-top:15px;">Create an Account</button></a>
				</p>
			</div>
			<div class="loginbox" style="background-image:url(css/images/login-box-bg.gif);">
				<h3>REGISTERED USER</h3>
				<p>If you already have an account with us, use your email and password to login.</p>
				<?php loginErrors(); ?>
				<form action="login-check.php" method="post">
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
								<strong>Password:</strong><span class="green-text">*</span>
							</td>
						</tr>
						<tr>
							<td>
								<input type="password" name="password" />
							</td>
						</tr>
						<tr>
							<td>
								<a href=""><strong>Forgot your password?</strong></a>
							</td>
							<td>
								<span class="red-text">* Required Fields</span>
							</td>
						</tr>
						<tr>
							<td>
								<button class="button" type="submit" style="padding:10px 15px;">Login</button>
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