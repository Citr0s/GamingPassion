<?php
function loggedIn()
{
    if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        $logged_in = true;
        return $logged_in;
    }
}

function loginCheck($connection, $username, $password)
{

    sanitise($connection, $username);
    sanitise($connection, $password);

    if (empty($username) || empty($password)) {
        header("Location: /login.php?error=1");
    } elseif (!empty($username) && !empty($password)) {

        $data = mysqli_query($connection, "SELECT * FROM `users` WHERE '$username' = `username` LIMIT 1");

        while ($row = mysqli_fetch_array($data)) {
            $user_info = array($row['user_id'], $row['username'], $row['password'], $row['email'], $row['active'], $row['status'], $row['joined']);
        }

        if ($username != $user_info[1] || md5($password) != $user_info[2]) {
            header("Location: /login.php?error=2");
        } elseif ($user_info[4] == 0) {
            header("Location: /login.php?error=3");
        } elseif ($user_info[4] == 1) {
            if ($username === $user_info[1] && md5($password) === $user_info[2]) {
                $_SESSION['username'] = $username;
                header("Location: index.php?success");
            }
        }
    }
}

function adminCheck($connection)
{
    $username = $_SESSION['username'];

    $data = mysqli_query($connection, "SELECT * FROM users WHERE '$username' = username LIMIT 1");

    while ($row = mysqli_fetch_array($data)) {
        $user_info = array($row['user_id'], $row['username'], $row['password'], $row['email'], $row['active'], $row['status'], $row['joined']);
    }

    if ($user_info[5] != 'admin') {
        header("Location: 	index.php");
    }
}

function adminUser($connection)
{
    $username = $_SESSION['username'];

    $data = mysqli_query($connection, "SELECT * FROM users WHERE '$username' = username LIMIT 1");

    while ($row = mysqli_fetch_array($data)) {
        $user_info = array($row['user_id'], $row['username'], $row['password'], $row['email'], $row['active'], $row['status'], $row['joined']);
    }

    if ($user_info[5] == 'admin') {
        $adminCheck = true;
        return $adminCheck;
    }
}

function modUser($connection)
{
    $username = $_SESSION['username'];

    $data = mysqli_query($connection, "SELECT * FROM users WHERE '$username' = username LIMIT 1");

    while ($row = mysqli_fetch_array($data)) {
        $user_info = array($row['user_id'], $row['username'], $row['password'], $row['email'], $row['active'], $row['status'], $row['joined']);
    }

    if ($user_info[5] == 'mod') {
        $modCheck = true;
        return $modCheck;
    }
}


function getUserDetails($connection, $username = null)
{
    $user = new \GamingPassion\Models\User();

    $data = mysqli_query($connection, "SELECT * FROM `users` WHERE username = '$username'");

    if ($data == false) {
        return null;
    }

    while ($row = mysqli_fetch_array($data)) {
        $active = $row['active'];
        $thumbnail = $row['thumbnail'];
        $name = $row['name'];
        $surname = $row['surname'];
        $age = $row['birthday'];
        $email = $row['email'];
        $user_id = $row['user_id'];
        $status = $row['status'];

        if (empty($thumbnail)) {
            $thumbnail = '/assets/images/image-missing.jpg';
        }

        $user->id = $user_id;
        $user->username = $username;
        $user->thumbnail = $thumbnail;
        $user->name = $name;
        $user->surname = $surname;
        $user->age = $age;
        $user->email = $email;
        $user->active = $active;
        $user->status = $status;
    }

    return $user;
}

function showOneUser($connection)
{
    $user = $_GET['user'];

    $data2 = mysqli_query($connection, "SELECT * FROM `mod_users` ORDER BY user_id");

    while ($row2 = mysqli_fetch_array($data2)) {
        if ($user == $row2['username']) {
            $user_exists = true;
            break;
        } else {
            $user_exists = false;
        }
    }

    if ($user_exists == false) {
        echo '<center><h1>Taki u&#380;ytkownik nie istnieje!</h1><br /><p><a href="http://www.gaming-passion.eu/">Wr&#243;&#263; na Stron&#281; G&#322;&#243;wna.</a></p></center>';
    } else {

        $data = mysqli_query($connection, "SELECT * FROM `mod_users` WHERE username = '$user'");

        while ($row = mysqli_fetch_array($data)) {
            $active = $row['active'];
            $thumbnail = $row['thumbnail'];
            $name = $row['name'];
            $surname = $row['surname'];
            $age = $row['birthday'];
            $bio = $row['bio'];
            $email = $row['email'];
            $user_id = $row['user_id'];

            if (empty($thumbnail)) {
                $thumbnail = '/assets/images/image-missing.jpg';
            }
            if (empty($name)) {
                $name = ' - ';
            }
            if (empty($surname)) {
                $surname = ' - ';
            }
            if (empty($age)) {
                $age = ' - ';
            }
            if (empty($bio)) {
                $bio = ' - ';
            }
            if (empty($email)) {
                $email = ' - ';
            }

            $data2 = mysqli_query($connection, "SELECT * FROM `posts` WHERE '$user' = post_author");
            $post_count = 0;
            while ($row2 = mysqli_fetch_array($data2)) {
                $post_count++;
            }

            $joined = strtotime($row['joined']);
            $today = time();

            $time_with_us = ($today - $joined) / 86400;
            $time_with_us = intval($time_with_us);

            $days = $time_with_us;
            $years = 0;

            while ($days >= 360) {
                $years++;

                $days = $days - 360;
            }

            if ($days == 1) {
                $days = $days . ' dzie&#324; ';
            } else {
                $days = $days . ' dni ';
            }

            if ($years != 0) {
                switch ($years) {
                    case 1:
                        $years = $years . ' rok ';
                        break;
                    case 2:
                        $years = $years . ' lata ';
                        break;
                    case 3:
                        $years = $years . ' lata ';
                        break;
                    case 4:
                        $years = $years . ' lata ';
                        break;
                    default:
                        $years = $years . ' lat ';
                        break;
                }
            } else {
                $years = '';
            }

            $age = strtotime($row['birthday']);
            $today = time();

            $time_alive = ($today - $age) / 86400;
            $time_alive = intval($time_alive);

            $days2 = $time_alive;
            $years2 = 0;

            while ($days2 >= 360) {
                $years2++;

                $days2 = $days2 - 360;
            }

            if ($years2 == 44) {
                $years2 = ' - ';
            }

            if ($active == 1) {
                echo '
				<p><a href="../" style="float:left;">< Strona G&#322;&#243;wna</a></p><br />
				<p><a href="/users" style="float:left;">< Wszyscy U&#380;ytkownicy</a></p>			
				<div class="holder"></div><br />
						<h1>' . $user . '</h1>
						<div id="user-info-sidebar">
							<div class="user-info-sidebar-block">
									<img src="' . $thumbnail . '" width="200" height="200" /><br />
								<h3>' . $user . '</h3>';

                if ($_GET['user'] == $_SESSION['username']) {
                    if (adminUser($connection) == true) {
                        echo '<p><a href="/admin/edit_mod_entry.php?user_id=' . $user_id . '">Edytuj</a></p><br />';
                    } elseif (modUser($connection) == true) {
                        echo '<p><a href="/mod/edit_mod_entry.php?user_id=' . $user_id . '">Edytuj</a></p><br />';
                    }
                }

                echo '				<p>Imi&#281;: <strong>' . $name . '</strong></p>
								<p>Nazwisko: <strong>' . $surname . '</strong></p>
								<p>Wiek: <strong>' . $years2 . '</strong></p>
								<p>Ksywa: <strong>' . $user . '</strong></p>
								<p style="float:left;">Co&#347; o sobie:&nbsp;</p><p style="float:left; text-align:justify;"><strong>' . $bio . '</strong></p>
								<div class="holder"></div>
							</div>
							<div class="user-info-sidebar-block">
								<h4>Statystyki</h4>
						<!--	<p>Tytul: -</p> -->
								<p>Czas z nami: <strong>' . $years . '' . $days . '</strong></p> 
								<p>Napisane posty: <strong>' . $post_count . '</strong></p>
							</div>
							<div class="user-info-sidebar-block">
								<h4>Kontakt</h4>
								<p>Email: <strong><a href="mailto:' . $email . '">' . $email . '</a></strong></p>
							</div>
						</div>
						<div id="user-info-list">
							<div class="green-message-profile">
								Posty napisane przez ' . $user . ' (' . $post_count . ')
							</div>
				<p>
				';
                $data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_author` = '$user' ORDER BY `post_id` DESC");
                $post_count = 0;

                while ($row = mysqli_fetch_array($data)) {

                    $timestamp = strtotime($row['timestamp']);
                    $date = date('d/m/Y', $timestamp);
                    $time = date('G:i', $timestamp);
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_count++;
                    $public = $row['public'];
                    $thumbnail = $row['thumbnail'];

                    if (empty($thumbnail)) {
                        $thumbnail = '/assets/images/image-missing.jpg';
                    }

                    if ($public == 1) {
                        echo '<div class="post-small"><a href="/article/?post_id=' . $post_id . '"><img src="' . $thumbnail . '" width="50" height="50" style="float:left; border:1px solid #666; margin:20px 5px 0px 0px;" /></a><a href="/article/?post_id=' . $post_id . '"><br /><h3>' . $post_title . '</h3></a><p>' . substr($post_content, 0, 152) . '&nbsp;<a href="/article/?post_id=' . $post_id . '" style="font-weight:bold;">(czytaj dalej / skomentuj)</a></p><br /></div>';
                    }
                }
                if ($post_count == 0) {
                    echo '<center><h3>Ten uzytkownik nie napisal zadnych postow.</h3></center>';
                }
                echo '</p>';
            } else {
                echo '<p><a href="index.php">< Strona G&#322;&#243;wna</a></p><center><h3>Ten uzytkownik jest zablokowany.</h3></center>';
            }
            echo '</div>';
        }
    }
}

function showUsers()
{
    echo '<h1>NASI REDAKTORZY</h1>';
    $data = mysqli_query($connection, "SELECT * FROM `mod_users` WHERE active = 1 ORDER BY `user_id`");
    $user_count = 0;

    while ($row2 = mysqli_fetch_array($data)) {
        $user_count++;
        $active = $row2['active'];
        $thumbnail = $row2['thumbnail'];
        $user = $row2['username'];
        $name = $row2['name'];
        $surname = $row2['surname'];
        $age = $row2['birthday'];
        $bio = $row2['bio'];
        $email = $row2['email'];

        if (empty($thumbnail)) {
            $thumbnail = '/assets/images/image-missing.jpg';
        }
        if (empty($bio)) {
            $bio = ' - ';
        }

        if ($active == 1) {
            echo '
			<div class="post-small">
				<a href="/users/?user=' . $user . '">
					<img src="' . $thumbnail . '" width="50" height="50" style="float:left; margin-right:5px; border:1px solid #cccccc;" />
				</a>
				<h6>&nbsp;</h6>
				<a href="/users/?user=' . $user . '">
					<h2>' . $user . '</h2>
				</a>
				<p>' . $bio . '</p>
			</div>';
        }
    }
    if ($user_count == 0) {
        echo '<center><h1>Obecnie nie ma zadnych uzytkownikow w naszej bazie danych.</h1></center>';
    }
}

?>