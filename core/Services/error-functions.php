<?php
function loginErrors(){
	if(isset($_GET['error'])){
		if($_GET['error'] == 1){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>All <strong>fields</strong> are required.</td></tr></table></div>';	
		}elseif($_GET['error'] == 2){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Username and Password <strong>don\'t match</strong>.</td></tr></table></div>';
		}elseif($_GET['error'] == 3){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>This account has been <strong>terminated</strong>.</td></tr></table></div>';
		}else{
			header("Location: login.php");	
		}
	}
}
function registerErrors(){
	if(isset($_GET['error'])){
		if($_GET['error'] == 1){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>All <strong>fields</strong> are required.</td></tr></table></div>';	
		}elseif($_GET['error'] == 2){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Username and Password have be <strong>at least 4</strong> characters long.</td></tr></table></div>';
		}elseif($_GET['error'] == 3){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td><strong>Passwords</strong> do not match.</td></tr></table></div>';
		}elseif($_GET['error'] == 4){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>User with this <strong>username</strong> already exists.</td></tr></table></div>';
		}elseif($_GET['error'] == 5){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>User with this <strong>email</strong> address already exists.</td></tr></table></div>';
		}elseif($_GET['error'] == 6){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>This is not a valid <strong>email</strong> address.</td></tr></table></div>';
		}elseif($_GET['error'] == 7){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td><strong>Recaptcha</strong> is wrong.</td></tr></table></div>';
		}else{
			header("Location: register.php");
		}
	}
}
function uploadErrors(){
	if(isset($_GET['error'])){
		if($_GET['error'] == 1){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td><strong>Photo</strong> was not changed.</td></tr></table></div>';
		}elseif($_GET['error'] == 2){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Picture is <strong>too big</strong>. Max size is 500kb.</td></tr></table></div>';
		}elseif($_GET['error'] == 3){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Wrong filetype. Only use <strong>JPG</strong>, <strong>PNG</strong> or <strong>GIF</strong></td></tr></table></div>';
		}elseif($_GET['error'] == 4){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>All <strong>fields</strong> are required.</td></tr></table></div>';	
		}elseif($_GET['error'] == 5){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td><strong>Something</strong> went wrong. Please try again in few minutes.</td></tr></table></div>';	
		}elseif($_GET['error'] == 6){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>There must be at least <strong>2</strong> photos in the slideshow.</td></tr></table></div>';	
		}else{
			header("Location: dashboard.php");	
		}
	}
}
?>