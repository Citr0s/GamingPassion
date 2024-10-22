<?php
include_once 'core/bootstrap.php';

if (!loggedIn()) {
    header("Location: index.php");
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
                ?>

                <p>
                    <strong>You are here:</strong> <a href="index.php">HOME</a> > <a href="/profile.php?user=<?php echo $user; ?>">MY PROFILE</a> > <a href="edit.php?user='.$user.'">EDIT</a>
                </p><br/>
                <?php

                if ($user != $_SESSION['username']) {
                    header("Location: /");
                    die();
                }

                $user_data = mysqli_query($connection, "SELECT * FROM `users` WHERE username = '$user'");

                while ($user_row = mysqli_fetch_array($user_data)) {
                    $user_id = $user_row['user_id'];
                }

                $current_password = $_POST['current_password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $new_password_check = $_POST['new_password_check'] ?? '';

                if (isset($_POST['current_password'])) {
                    if (!empty($current_password) && !empty($new_password) && !empty($new_password_check)) {
                        $current_password_check = md5($current_password);
                        $data4 = mysqli_query($connection, "SELECT * FROM `users` WHERE password = '$current_password_check'");
                        while ($row = mysqli_fetch_array($data4)) {
                            if ($current_password_check == $row['password']) {
                                $good_pass = true;
                            }
                        }
                        if ($good_pass != true) {
                            echo '<div class="red-message">Incorrect <strong>password</strong>.</div>';
                        }
                        if ($new_password != $new_password_check) {
                            echo '<div class="red-message">The new passwords do not match.</div>';
                        } elseif ($new_password === $new_password_check) {
                            $new_password = md5($new_password);
                            mysqli_query($connection, "UPDATE `users` SET password = '$new_password' WHERE $user_id = user_id");
                            echo '<div class="green-message">Your password has been updated successfully.</div>';
                        }
                    }
                    echo '<p><a href="/profile.php?user=' . $_SESSION['username'] . '">< MY PROFILE</a></p>';
                    echo '<div class="red-message">Please fill in all fields marked with asterisks (*).</div>';
                } elseif (isset($_POST['email'])) {
                    if (empty($_POST['email'])) {
                        echo '
								<div class="red-message">
									<table>
										<tr>
											<td style="padding-right:5px;">
												<img src="assets/images/popup-warning-icon.png" />
											</td>
											<td>
												Fields marked with the asterisks (*) are required.
											</td>
										</tr>
									</table>
								</div>
								';
                    } else {

                        $data = mysqli_query($connection, "SELECT * FROM `users` WHERE $user_id = user_id");

                        while ($row = mysqli_fetch_array($data)) {
                            $thumbnail = $row['thumbnail'];
                        }

                        if (isset($_POST['delete_avatar'])) {
                            unlink($thumbnail);
                            $thumbnail = '';
                            mysqli_query($connection, "UPDATE `users` SET thumbnail = '$thumbnail' WHERE $user_id = user_id");
                        }

                        if (!empty($_POST['filename'])) {

                            $data = mysqli_query($connection, "SELECT * FROM `users` WHERE $user_id = user_id");

                            while ($row = mysqli_fetch_array($data)) {
                                $thumbnail = $row['thumbnail'];
                            }

                            unlink($thumbnail);

                            $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
                            $length = 5;
                            $newName = '';

                            for ($i = 0; $i < $length; $i++) {
                                $newName .= $chars[mt_rand(0, 36)];
                            }

                        }

                        if ($_FILES) {
                            $name = $_FILES['filename']['name'];

                            switch ($_FILES['filename']['type']) {
                                case 'image/jpeg':
                                    $ext = 'jpg';
                                    break;
                                case 'image/gif':
                                    $ext = 'gif';
                                    break;
                                case 'image/png':
                                    $ext = 'png';
                                    break;
                                default:
                                    $ext = '0';
                                    break;
                            }

                            if (empty($name)) {
                                echo "(Avatar was not changed.)";
                                $data = mysqli_query($connection, "SELECT * FROM `users` WHERE $user_id = user_id");

                                while ($row = mysqli_fetch_array($data)) {
                                    $thumbnail = $row['thumbnail'];
                                }
                            } else {
                                $size = $_FILES['filename']['size'];
                                if ($size > 524288) {
                                    echo "<div class='red-message'>Avatar is too big. Max size is 500kb.</div>";
                                    $data = mysqli_query($connection, "SELECT * FROM `users` WHERE $user_id = user_id");

                                    while ($row = mysqli_fetch_array($data)) {
                                        $thumbnail = $row['thumbnail'];
                                    }
                                } else {
                                    if ($ext) {
                                        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
                                        $length = 5;
                                        $newName = '';

                                        for ($i = 0; $i < $length; $i++) {
                                            $newName .= $chars[mt_rand(0, 36)];
                                        }

                                        $n = "uploads/users/$newName.$ext";
                                        move_uploaded_file($_FILES['filename']['tmp_name'], $n);
                                        $thumbnail = $n;
                                    } else {
                                        echo "<div class='red-message'>Wrong file type! ('$name')</div>";
                                    }
                                }
                            }

                        } else {
                            echo "Avatar was not changed.";
                        }

                        $gender = $_POST['sex'];
                        $email = $_POST['email'];
                        $from = $_POST['from'];

                        mysqli_query($connection, "UPDATE `users` SET thumbnail = '$thumbnail', gender = '$gender', home = '$from', email = '$email' WHERE $user_id = user_id");
                        echo '<p><a href="/profile.php?user=' . $_SESSION['username'] . '">< MY PROFILE</a></p>';
                        echo '
									<div class="green-message">
										<table>
											<tr>
												<td style="padding-right:5px;">
													<img src="assets/images/popup-info-icon.png" />
												</td>
												<td>
													Your profile has been edited successfully.
												</td>
											</tr>
										</table>
									</div>
									';
                    }
                }

                $data = mysqli_query($connection, "SELECT * FROM `users` WHERE $user_id = user_id");

                while ($row = mysqli_fetch_array($data)) {
                    $thumbnail = $row['thumbnail'];
                    $gender = $row['gender'];
                    $email = $row['email'];
                    $from = $row['home'];
                    $avatar = 0;

                    if (empty($thumbnail)) {
                        $thumbnail = 'assets/images/image-missing.jpg';
                        $avatar = 1;
                    }

                    echo '
							<h1 style="font-family: \'Open Sans\', sans-serif; font-size:20px; margin-top:10px;">EDIT</h1>
							<div class="form-table">
								<center>
									<form action="#" method="post" enctype="multipart/form-data">
										<table class="edit-profile-table">
											<tr>
												<td valign="middle" class="required">Email:<span class="green-text">*</span></td><td style="text-align:left;"><input type="email" name="email" value="' . $email . '"/></td>
											</tr>
											<tr>
												<td valign="middle" class="required">From:</td><td style="text-align:left;"><input type="text" name="from" value="' . $from . '"/></td>
											</tr>
											<tr>
												<td valign="top">Avatar:</td><td style="text-align:left;"><img src="' . $thumbnail . '" height="100" /></td>
											</tr>
											<tr>
												<td>';
                    if ($avatar == 0) {
                        echo 'Delete Your Avatar:</td><td style="text-align:left;"><input type="checkbox" name="delete_avatar" style="width:10px; margin:5px;" />';
                    }

                    echo '</td>
											</tr>
											<tr>
												<td valign="middle">Change Your Avatar:</td><td style="text-align:left;"><input type="file" name="filename" style="width:200px;" /></td>
											</tr>
											<tr>
												<td valign="middle" class="required">Sex:</td><td style="text-align:left;"><input type="radio" name="sex" value="male" style="width:10px; margin:5px;" ';
                    if ($gender == 'male') {
                        echo 'checked';
                    }
                    echo ' >Male</td>
											</tr>
											<tr>
												<td></td><td style="text-align:left;"><input type="radio" name="sex" value="female" style="width:10px; margin:5px;" ';
                    if ($gender == 'female') {
                        echo 'checked';
                    }
                    echo ' >Female</td>
											</tr>
											<tr>	
												<td></td><td style="text-align:left;"><input type="radio" name="sex" value="unknown" style="width:10px; margin:5px;" ';
                    if ($gender == 'unknown') {
                        echo 'checked';
                    }
                    echo '>Don\'t Tell</td>
											</tr>
											<tr>
												<td></td><td style="text-align:left;"><button type="submit" class="button">Save</button></td>
											</tr>
											<tr>
										</table>
									</form>
								</center>
							</div>
						';

                    echo '<br />
							<h1 style="font-family: \'Open Sans\', sans-serif; font-size:20px; margin-top:10px;">CHANGE PASSWORD</h1>
							<div class="form-table">
								<center>
									<form action="#" method="post">
										<table class="edit-profile-table">
											<tr>
												<td valign="middle" class="required">Current Password:<span class="green-text">*</span></td><td><input type="password" name="current_password" value="" /></td>
											</tr>
											<tr>
												<td valign="middle" class="required">New Password:<span class="green-text">*</span></td><td><input type="password" name="new_password" value="" /></td>
											</tr>
											<tr>
												<td valign="middle" class="required">Confirm Password:<span class="green-text">*</span></td><td><input type="password" name="new_password_check" value="" /></td>
											</tr>
											<tr>
												<td></td><td style="text-align:left;"><button type="submit" class="button">Change Password</button></td>
											</tr>
										</table>
									</form>
								</center>
							</div>
						';
                }
                ?>
            </div>
            <?php include_once 'includes/sidebar.php'; ?>
        </div>
    </div>
<?php
include_once 'includes/footer.php';
?>