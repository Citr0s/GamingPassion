<?php
function sanitise($object){
	htmlentities(mysql_real_escape_string($object));
}
function loginErrors(){
	if(isset($_GET['error'])){
		if($_GET['error'] == 1){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Proszę wypełnić wszystkie pola.</td></tr></table></div>';	
		}elseif($_GET['error'] == 2){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Login lub Hasło są niepoprawne.</td></tr></table></div>';
		}elseif($_GET['error'] == 3){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Twoje konto nie zostało zablokowane.</td></tr></table></div>';
		}else{
			header("Location: signin.php");	
		}
	}
}
function registerErrors(){
	if(isset($_GET['error'])){
		if($_GET['error'] == 1){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Proszę wypełnić wszystkie pola.</td></tr></table></div>';	
		}elseif($_GET['error'] == 2){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Login i Hasło muszą zawierać przynajmniej 4 znaki.</td></tr></table></div>';
		}elseif($_GET['error'] == 3){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Hasła różnią się od siebie.</td></tr></table></div>';
		}elseif($_GET['error'] == 4){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Użytkownik z takim <strong>loginem</strong> już istnieje.</td></tr></table></div>';
		}elseif($_GET['error'] == 5){
			echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-warning-icon.png" /></td><td>Użytkownik z takim <strong>emailem</strong> juz istnieje.</td></tr></table></div>';
		}else{
			header("Location: register.php");
		}
	}
}
?>