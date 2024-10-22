<?php
$username = $_SESSION['username'];

$total_post_count = 0;
$approved_post_count = 0;
$rejected_post_count = 0;
$news_post_count = 0;
$review_post_count = 0;
$guide_post_count = 0;
$gameplay_post_count = 0;

$overall_user_count = 0;
$active_user_count = 0;
$unactive_user_count = 0;

$overall_comment_count = 0;
$active_comment_count = 0;
$unactive_comment_count = 0;

$user_total_post_count = 0;
$user_approved_post_count = 0;
$user_rejected_post_count = 0;
$user_news_post_count = 0;
$user_review_post_count = 0;
$user_guide_post_count = 0;
$user_gameplay_post_count = 0;
$user_overall_comment_count = 0;
$user_active_comment_count = 0;
$user_unactive_comment_count = 0;

/** Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $total_post_count++;
}
/** Post Count End **/

/** Approved Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `public` = 1 ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $approved_post_count++;
}
/** Approved Post Count End **/

/** Rejected Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `public` = 0 ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $rejected_post_count++;
}
/** Rejected Post Count End **/

/** News Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'news' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $news_post_count++;
}
/** News Post Count End **/

/** Review Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'recenzja' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $review_post_count++;
}
/** Review Post Count End **/

/** Guide Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'poradnik' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $guide_post_count++;
}
/** Guide Post Count End **/

/** Gameplay Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'gameplay' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $gameplay_post_count++;
}
/** Gameplay Post Count End **/

/** Overall User Count **/
$user_count = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `user_id`");

while ($user_count_row = mysqli_fetch_array($user_count)) {
    $overall_user_count++;
}
/** Overall User Count End **/

/** Active User Count **/
$user_count = mysqli_query($connection, "SELECT * FROM `users` WHERE `active` = 1 ORDER BY `user_id`");

while ($user_count_row = mysqli_fetch_array($user_count)) {
    $active_user_count++;
}
/** Active User Count End **/

/** Unactive User Count **/
$user_count = mysqli_query($connection, "SELECT * FROM `users` WHERE `active` = 0 ORDER BY `user_id`");

while ($user_count_row = mysqli_fetch_array($user_count)) {
    $unactive_user_count++;
}
/** Unactive User Count End **/

/** Overall Comment Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY `comment_id`");

while ($user_count_row = mysqli_fetch_array($comment_count)) {
    $overall_comment_count++;
}
/** Overall Comment Count End **/

/** Active Comment Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` WHERE `active` = 1 ORDER BY `comment_id`");

while ($user_count_row = mysqli_fetch_array($comment_count)) {
    $active_comment_count++;
}
/** Active Comment Count End **/

/** Unactive Comment Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` WHERE `active` = 0 ORDER BY `comment_id`");

while ($user_count_row = mysqli_fetch_array($comment_count)) {
    $unactive_comment_count++;
}
/** Unactive Comment Count End **/

/** User Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_author` = '$username' ORDER BY `post_id` DESC");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_total_post_count++;
}
/** User Post Count End **/

/** User Approved Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `public` = 1 AND `post_author` = '$username' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_approved_post_count++;
}
/** User Approved Post Count End **/

/** User Rejected Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `public` = 0 AND `post_author` = '$username' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_rejected_post_count++;
}
/** User Rejected Post Count End **/

/** User News Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'news' AND `post_author` = '$username' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_news_post_count++;
}
/** User News Post Count End **/

/** User Review Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'recenzja' AND `post_author` = '$username' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_review_post_count++;
}
/** User Review Post Count End **/

/** User Guide Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'poradnik' AND `post_author` = '$username' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_guide_post_count++;
}
/** User Guide Post Count End **/

/** User Gameplay Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'gameplay' AND `post_author` = '$username' ORDER BY `post_id`");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $user_gameplay_post_count++;
}
/** User Gameplay Post Count End **/

/** User Overall Comment Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` WHERE `comment_author` = '$username' ORDER BY `comment_id`");

while ($user_count_row = mysqli_fetch_array($comment_count)) {
    $user_overall_comment_count++;
}
/** User Overall Comment Count End **/

/** User Active Comment Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` WHERE `active` = 1 AND `comment_author` = '$username' ORDER BY `comment_id`");

while ($user_count_row = mysqli_fetch_array($comment_count)) {
    $user_active_comment_count++;
}
/** User Active Comment Count End **/

/** User Unactive Comment Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` WHERE `active` = 0 AND `comment_author` = '$username' ORDER BY `comment_id`");

while ($user_count_row = mysqli_fetch_array($comment_count)) {
    $user_unactive_comment_count++;
}
/** User Unactive Comment Count End **/

$public_post_percentage = round(($approved_post_count / $total_post_count) * 100, 0);
$rejected_post_percentage = round(($rejected_post_count / $total_post_count) * 100, 0);

$active_user_percentage = round(($active_user_count / $overall_user_count) * 100, 0);
$unactive_user_percentage = round(($unactive_user_count / $overall_user_count) * 100, 0);

$active_comment_percentage = round(($active_comment_count / $overall_comment_count) * 100, 0);
$unactive_comment_percentage = round(($unactive_comment_count / $overall_comment_count) * 100, 0);

/** Posts/Day Post Count **/
$post_count = mysqli_query($connection, "SELECT * FROM `posts` ORDER BY `post_id` DESC LIMIT 1");

while ($post_count_row = mysqli_fetch_array($post_count)) {
    $first_post_date = strtotime($post_count_row['timestamp']);
}
$days_since_first_post = intval((time() - $first_post_date) / 86400);
$posts_per_day = round($total_post_count / $days_since_first_post, 1);

/** Posts/Day Post Count End **/

/** Users/Day Post Count **/
$user_count = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `user_id` DESC LIMIT 1");

while ($user_count_row = mysqli_fetch_array($user_count)) {
    $first_user_date = strtotime($user_count_row['joined']);
}
$days_since_first_user = intval((time() - $first_user_date) / 86400);
$users_per_day = round($overall_user_count / $days_since_first_user, 1);

/** Users/Day Post Count End **/

/** Comments/Day Post Count **/
$comment_count = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY `comment_id` DESC LIMIT 1");

while ($comment_count_row = mysqli_fetch_array($comment_count)) {
    $first_comment_date = strtotime($comment_count_row['timestamp']);
}
$days_since_first_comment = intval((time() - $first_user_date) / 86400);
$comments_per_day = round($overall_user_count / $days_since_first_comment, 1);

/** Comments/Day Post Count End **/

function showAllPostsDashboard()
{
    if (adminUser($connection)) {
        $data = mysqli_query($connection, "SELECT * FROM `posts` WHERE section = 'pl' ORDER BY `post_id` DESC");
    } else {
        $data = mysqli_query($connection, "SELECT * FROM `posts` WHERE section = 'pl' AND `author` = '$_SESSION[username]' ORDER BY `post_id` DESC");
    }
    $post_count = 0;
    $comment_count = 0;

    while ($row = mysqli_fetch_array($data)) {
        $timestamp = strtotime($row['timestamp']);
        $date = date('d.m.Y', $timestamp);
        $time = date('G:i', $timestamp);
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_content = $row['post_content'];
        $post_count++;
        $public = $row['public'];
        $thumbnail = $row['thumbnail'];
        $hours_ago = intval((time() - $timestamp) / 3600);
        $days_ago = intval((time() - $timestamp) / 86400);
        $years_ago = intval(((time() - $timestamp) / 86400) / 365);

        $time = date("H:i", $timestamp);

        if ($hours_ago < 1) {
            $hours_ago = 'mniej niż godzine temu';
        } elseif ($hours_ago == 1) {
            $hours_ago = $hours_ago . ' godzine temu';
        } elseif ($hours_ago < 5) {
            $hours_ago = $hours_ago . ' godziny temu';
        } elseif ($hours_ago >= 5 && $hours_ago < 22) {
            $hours_ago = $hours_ago . ' godzin temu';
        } elseif ($hours_ago >= 22 && $hours_ago < 24) {
            $hours_ago = $hours_ago . ' godziny temu';
        } elseif ($hours_ago >= 24 && $days_ago == 1) {
            $hours_ago = $days_ago . ' dzień temu';
        } elseif ($days_ago > 1) {
            $hours_ago = $days_ago . ' dni temu';
        } elseif ($days_ago > 365 && $years_ago >= 1) {
            $hours_ago = $years_ago . ' rok temu';
        } elseif ($years_ago > 1) {
            $hours_ago = $years_ago . ' lata temu';
        }

        $day = date('d', $timestamp);
        $month = date('m', $timestamp);

        switch ($month) {
            case 1:
                $month = 'January';
                break;
            case 2:
                $month = 'February';
                break;
            case 3:
                $month = 'March';
                break;
            case 4:
                $month = 'April';
                break;
            case 5:
                $month = 'May';
                break;
            case 6:
                $month = 'June';
                break;
            case 7:
                $month = 'July';
                break;
            case 8:
                $month = 'August';
                break;
            case 9:
                $month = 'September';
                break;
            case 10:
                $month = 'October';
                break;
            case 11:
                $month = 'November';
                break;
            case 12:
                $month = 'December';
                break;
            default:
                $month = '';
                break;
        }

        $year = date('Y', $timestamp);

        $comment_data = mysqli_query($connection, "SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

        while ($comment_row = mysqli_fetch_array($comment_data)) {
            $comment_count++;
        }

        if (empty($thumbnail)) {
            $thumbnail = 'assets/images/image-missing.jpg';
        }

        if (strlen($post_content) > 255) {
            $end = '<a href="../article/?id=' . $post_id . '" title="' . strtoupper($post_title) . '">(czytaj dalej / skomentuj)</a>';
        } else {
            $end = '<a href="../article/?id=' . $post_id . '" title="' . strtoupper($post_title) . '">(skomentuj)</a>';
        }

        $total_ratings = 0;
        $total_score = 0;
        $datax = mysqli_query($connection, "SELECT * FROM `ratings` WHERE `post_id` = $post_id");
        while ($rowx = mysqli_fetch_array($datax)) {
            $rating = $rowx['rating'];
            $author = $rowx['author'];
            $total_score += $rating;
            $total_ratings++;
        }

        if ($total_ratings != 0) {
            $average_rating = $total_score / $total_ratings;
            settype($average_rating, 'float');
        }

        if (loggedIn() && notVoted($connection, $post_id)) {
            $rating = '
	        	<div class="stars-bg">
	        		<a href="../article/vote.php?post_id=' . $post_id . '&rating=1"><div class="star-1"></div></a>
	        		<a href="../article/vote.php?post_id=' . $post_id . '&rating=2"><div class="star-2"></div></a>
	        		<a href="../article/vote.php?post_id=' . $post_id . '&rating=3"><div class="star-3"></div></a>
	        		<a href="../article/vote.php?post_id=' . $post_id . '&rating=4"><div class="star-4"></div></a>
	        		<a href="../article/vote.php?post_id=' . $post_id . '&rating=5"><div class="star-5"></div></a>
	        		<a href="../article/vote.php?post_id=' . $post_id . '&rating=6"><div class="holder"></div></a>
	        	</div>
			';
        } else {
            if ($total_score <= 0) {
                $rating = '<img src="/assets/images/rating-0-stars.png" title="' . $total_score . '/5" />';
            } elseif ($average_rating <= 1) {
                $rating = '<img src="/assets/images/rating-1-star.png" title="' . $average_rating . '/5" />';
            } elseif ($average_rating <= 2) {
                $rating = '<img src="/assets/images/rating-2-stars.png" title="' . $average_rating . '/5" />';
            } elseif ($average_rating <= 3) {
                $rating = '<img src="/assets/images/rating-3-stars.png" title="' . $average_rating . '/5" />';
            } elseif ($average_rating <= 4) {
                $rating = '<img src="/assets/images/rating-4-stars.png" title="' . $average_rating . '/5" />';
            } elseif ($average_rating <= 5) {
                $rating = '<img src="/assets/images/rating-5-stars.png" title="' . $average_rating . '/5" />';
            }
        }

        echo '
			<div class="dashboard-post">
				<div class="post-options">
					<div class="float-left">
						<strong>' . $post_id . '</strong>
					</div>
					<div class="float-right">
			';

        if ($public == 1) {
            echo '
						<i class="fa fa-check" style="color:#00a65a;" title="PUBLIC"></i>
						<a href="#" onclick="window.open(\'edit_post_entry.php?post_id=' . $row['post_id'] . '\',\'\',\'scrollbars=no, toolbar=no, menubar=no, location=no, personalbar=no, resizable=no, directories=no, status=no, width=640, height=700\')"><i class="fa fa-cog" title="EDIT"></i></a> 
						<a href="delete_post_entry.php?post_id=' . $row['post_id'] . '"<i class="fa fa-trash-o" title="DELETE"></i></a>
					';
        } else {
            echo '
						<i class="fa fa-times" style="color:#f56954;" title="NOT PUBLIC"></i>
						<a href="#" onclick="window.open(\'edit_post_entry.php?post_id=' . $row['post_id'] . '\',\'\',\'scrollbars=no, toolbar=no, menubar=no, location=no, personalbar=no, resizable=no, directories=no, status=no, width=640, height=700\')"><i class="fa fa-cog" title="EDIT"></i></a> 
						<a href="publish_post_entry.php?post_id=' . $row['post_id'] . '"<i class="fa fa-globe" title="PUBLISH"></i></a>
					';
        }

        $post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 200));
        htmlentities($post_content);

        echo '
					</div>
					<div class="holder"></div>
				</div>
				<div class="post-title"><a href="../?id=' . $post_id . '">' . strtoupper($post_title) . '</a></div>
				<div class="post-info">' . $post_author . ' at ' . $time . ' on ' . $day . ' ' . $month . ' ' . $year . '</div>
				<div class="post-thumbnail"><a href="../?id=' . $post_id . '"><img src="../' . $thumbnail . '" /></a></div>
				<div class="post-content">' . $post_content . '...</div>
				<a></a>
			</div>
			';
        $comment_count = 0;
    }
    if ($post_count == 0) {
        echo '<div class="empty_result">Currently there are no records in our database.</div>';
    }
}

function showAllUsersDashboard()
{
    $data = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `user_id`");
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
        $status = $row2['status'];
        $user_id = $row2['user_id'];

        if (empty($thumbnail)) {
            $thumbnail = 'assets/images/image-missing.jpg';
        }

        if (empty($bio)) {
            $bio = ' - ';
        }

        echo '
			<div class="dashboard-user-post">
				<div class="post-options">
					<div class="float-left">
						<strong>' . $user_id . '</strong>
					</div>
					<div class="float-right">
			';

        if ($active == 1) {
            echo '
						<i class="fa fa-check" style="color:#00a65a;" title="PUBLIC"></i>
						<a href="#" onclick="window.open(\'edit_user_entry.php?user_id=' . $user_id . '\',\'\',\'scrollbars=no, toolbar=no, menubar=no, location=no, personalbar=no, resizable=no, directories=no, status=no, width=640, height=700\')"><i class="fa fa-cog" title="EDIT"></i></a> 
						<a href="block_user_entry.php?user_id=' . $user_id . '"<i class="fa fa-trash-o" title="DELETE"></i></a>
					';
        } else {
            echo '
						<i class="fa fa-times" style="color:#f56954;" title="NOT PUBLIC"></i>
						<a href="#" onclick="window.open(\'edit_user_entry.php?user_id=' . $row['post_id'] . '\',\'\',\'scrollbars=no, toolbar=no, menubar=no, location=no, personalbar=no, resizable=no, directories=no, status=no, width=640, height=700\')"><i class="fa fa-cog" title="EDIT"></i></a> 
						<a href="activate_user_entry.php?user_id=' . $user_id . '"<i class="fa fa-globe" title="PUBLISH"></i></a>
					';
        }

        echo '
					</div>
					<div class="holder"></div>
				</div>
				<div class="post-title"><a href="../profile.php?id=' . $user_id . '">' . strtoupper($user) . '</a></div>
				<div class="post-info"></div>
				<div class="user-thumbnail"><a href="../profile.php?id=' . $user_id . '"><img src="../' . $thumbnail . '" /></a></div>
				<div class="post-content">
					<table style="margin-top:10px;">
						<tr>
							<td><strong>Email:</strong></td><td>' . $email . '</td>
						</tr>
						<tr>
							<td><strong>Status:</strong></td><td>' . $status . '</td>
						</tr>
					</table> 
				</div>
				<a></a>
			</div>
			';
    }
    if ($user_count == 0) {
        echo '<center><h1>Currently there are no users in our database.</h1></center>';
    }
}

function showAllCommentsDashboard($connection)
{
    $data = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY `comment_id`");
    $comment_count = 0;

    while ($row2 = mysqli_fetch_array($data)) {
        $comment_count++;
        $comment_id = $row2['comment_id'];
        $active = $row2['active'];
        $author = $row2['comment_author'];
        $comment_content = $row2['comment_content'];
        $comment_author_status = $row2['comment_author_status'];

        echo '
			<div class="dashboard-user-post" style="height:auto;">
				<div class="post-options">
					<div class="float-left">
						<strong>' . $author . '</strong>
					</div>
					<div class="float-right">
			';

        if ($active == 1) {
            echo '
						<i class="fa fa-check" style="color:#00a65a;" title="PUBLIC"></i>
						<a href="block_comment_entry.php?comment_id=' . $comment_id . '"<i class="fa fa-trash-o" title="DELETE"></i></a>
					';
        } else {
            echo '
						<i class="fa fa-times" style="color:#f56954;" title="NOT PUBLIC"></i>
						<a href="activate_comment_entry.php?comment_id=' . $comment_id . '"<i class="fa fa-globe" title="PUBLISH"></i></a>
					';
        }

        echo '
					</div>
					<div class="holder"></div>
				</div>
				<div class="post-title"><a href="../profile.php?id=' . $user_id . '">' . strtoupper($user) . '</a></div>
				<div class="post-info"></div>
				<div class="post-content">
					<table style="margin-top:10px;">
						<tr>
							<td><strong>User Rank:</strong></td><td>' . $comment_author_status . '</td>
						</tr>
						<tr>
							<td><strong>Content:</strong></td><td>' . $comment_content . '</td>
						</tr>
					</table> 
				</div>
				<a></a>
			</div>
			';
    }
    if ($comment_count == 0) {
        echo '<center><h1>Currently there are no comments in our database.</h1></center>';
    }
}

?>