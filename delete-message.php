<?php include 'core/bootstrap.php'; ?>
<?php
if (!loggedIn()) {
    header("Location: /");
    die();
}
?>
<?php
$message_id = $_GET['message_id'];
$user = $_SESSION['username'];
$message_count = 0;

$data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `to` = '$user' AND `message_id` = $message_id LIMIT 1");

while ($row = mysqli_fetch_array($data)) {
    $message_count++;
}

$data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `from` = '$user' AND `message_id` = $message_id LIMIT 1");

while ($row = mysqli_fetch_array($data)) {
    $message_count = $message_count + 2;
}

if ($message_count == 0) {
    header('Location: /');

} elseif ($message_count == 1) {

    if (isset($message_id)) {
        mysqli_query($connection, "UPDATE `private_messages` SET `active` = 0 WHERE `message_id` = $message_id");
    } else {
        header('Location: /');
    }
    header('Location: messages.php?deleted');

} elseif ($message_count == 2) {

    if (isset($message_id)) {
        mysqli_query($connection, "UPDATE `private_messages` SET `active` = 0 WHERE `message_id` = $message_id");
    } else {
        header('Location: /');
    }
    header('Location: messages.php?deleted');

} else {
    header('Location: /');
}
?>