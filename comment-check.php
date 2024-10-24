<?php include 'core/bootstrap.php'; ?>
<?php
if (!loggedIn()) {
    header("Location: /");
    die();
}
?>
<?php
$user = $_SESSION['username'];
$data = mysqli_query($connection, "SELECT * FROM `comments` WHERE `comment_author` = '$user' ORDER BY timestamp DESC LIMIT 1");

while ($row = mysqli_fetch_array($data)) {
    $last_comment_time = $row['timestamp'];
}

$last_comment_time = strtotime($last_comment_time);
$today = time();

$time_difference = $today - $last_comment_time;

$comment_content = $_POST['comment-content'];
$bot_check = $_POST['bot-check'];
$comment_author_status = $_POST['comment_author_status'];
$post_id = $_POST['post_id'];
$comment_author = $_SESSION['username'];
$response = $_POST['g-recaptcha-response'];

if (!empty($response)) {
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=6LeXsf4SAAAAAFWnf2InV1jw6icig2o_yNUR_9Lb&response=' . $response;
    $content = file_get_contents($url);
    $json = json_decode($content, true);

    if (isset($json['error-codes'])) {
        header('Location: /?id=' . $post_id . '&bot-alert');
    } elseif (isset($json['success'])) {
        if (!empty($comment_content) && !empty($comment_author_status)) {
            if ($time_difference < 300) {
                header('Location: /?id=' . $post_id . '&time');
            } else {
                mysqli_query($connection, "INSERT INTO `comments` (`comment_content`, `comment_author`, `comment_post_id`, `timestamp`, `active`, `comment_author_status`) VALUES ('$comment_content', '$comment_author', $post_id, CURRENT_TIMESTAMP, 1, '$comment_author_status')");
                header('Location: /?id=' . $post_id . '&success');
            }
        } else {
            header('Location: /?id=' . $post_id . '&fields-not-set');
        }
    }
} else {
    header('Location: /?id=' . $post_id . '&bot-alert');
}
?>