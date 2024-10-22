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
                <p>
                    <strong>You are here:</strong> <a href="index.php">HOME</a> > <a href="profile.php?user=<?php echo $username; ?>">MY PROFILE</a> > <a href="messages.php">PRIVATE MESSAGES</a>
                </p>
                <div id="badges-container">
                    <h1 class="h1" style="margin-top:5px;">PRIVATE MESSAGES</h1>
                    <?php
                    if (isset($_GET['success'])) {
                        echo '<div class="green-message"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>Your message has been sent successfully.</td></tr></table></div>';
                    }
                    if (isset($_GET['user-doesnt-exist'])) {
                        echo '';
                    }
                    if (isset($_GET['fields-not-set'])) {
                        echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>All fields are required.</td></tr></table></div>';
                    }
                    if (isset($_GET['bot-alert'])) {
                        echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>Bot alert. Try again.</td></tr></table></div>';
                    }
                    if (isset($_GET['self'])) {
                        echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>You can\'t send messages to yourself.</td></tr></table></div>';
                    }

                    $user = $_SESSION['username'];
                    $data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `from` = '$user' AND `active` = 1 ORDER BY `timestamp` DESC LIMIT 1");

                    while ($row = mysqli_fetch_array($data)) {
                        $last_comment_time = $row['timestamp'];
                    }

                    $last_comment_time = strtotime($last_comment_time);
                    $today = time();

                    $time_difference = $today - $last_comment_time;

                    $time_difference = 300 - $time_difference;

                    $minutes = intval(date('i', $time_difference));
                    $seconds = intval(date('s', $time_difference));

                    if (isset($_GET['time'])) {
                        echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>Not too fast! You can send your next message in <strong>' . $minutes . '</strong> minutes and <strong>' . $seconds . '</strong> seconds.</td></tr></table></div>';
                    }
                    ?>
                    <?php
                    $data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `to` = '$user' AND `active` = 1 ORDER BY `message_id` DESC");
                    $message_count = 0;

                    while ($row = mysqli_fetch_array($data)) {
                        $message_count++;
                    }
                    ?>
                    <h2 class="profile-sidebar-li-big" id="received" style="margin-top:10px;">INBOX (<?php echo $message_count; ?>)</h2>
                    <?php
                    receivedMessagesFull();
                    ?>
                    <?php
                    $data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `from` = '$user' AND `active_from` = 1 ORDER BY `message_id` DESC");
                    $sent_count = 0;

                    while ($row = mysqli_fetch_array($data)) {
                        $sent_count++;
                    }
                    ?>
                    <h2 class="profile-sidebar-li-big" id="sent">SENT (<?php echo $sent_count; ?>)</h2>
                    <?php
                    sentMessagesFull();
                    ?>
                    <h2 class="profile-sidebar-li-big" id="compose" style="	border-top:2px solid #ccc; padding-top:10px; margin-top:10px;">CREATE</h2>
                    <form method="post" action="message-check.php">
                        <table>
                            <tr>
                                <td style="text-align:right;">Title:<span class="green-text">*</span></td>
                                <td><input type="text" name="title"/></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;">To:<span class="green-text">*</span></td>
                                <td><input type="text" name="to"/></td>
                            </tr>
                            <?php if (adminUser()) {
                                echo '<tr><td align="right">Send to all:</td><td><input type="checkbox" name="send-to-all" style="width:15px; margin:10px;" /></td></tr>';
                            } ?>
                            <tr>
                                <td style="text-align:right;" valign="top">Message:<span class="green-text">*</span></td>
                                <td><textarea style="width:400px; max-width:400px;" name="content"></textarea></td>
                            </tr>
                            <tr>
                                <td>Capital of Poland?<span class="green-text">*</span></td>
                                <td style="text-align:left;"><input type="text" name="bot-check" class="text-field"/></td>
                                </td>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="button">Send</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <?php
            echo '
		<style>
			a:hover{text-decoration:none;}
		</style>
		<div id="sidebar">
			<div>
			<h1>Private Messages</h1>
			<a href="#received"><div class="profile-sidebar-li">Inbox</div></a>';
            echo '
			<a href="#sent"><div class="profile-sidebar-li">Sent</div></a>
			<a href="#compose"><div class="profile-sidebar-special">Create</div></a>
			</div>
		</div>';
            ?>
            <div class="holder"></div>
        </div>
    </div>
<?php
include_once 'includes/footer.php';
?>