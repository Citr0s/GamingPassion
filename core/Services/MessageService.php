<?php namespace GamingPassion\Services;

class MessageService
{
    function savePost($connection){
        $query = mysqli_query($connection, "SELECT * FROM `posts` ORDER BY `post_id` DESC LIMIT 1");

        while($row = mysqli_fetch_array($query)){
            $post_id = $row['post_id'] + 1;
        }

        if($_FILES){
            $name = $_FILES['filename']['name'];

            switch($_FILES['filename']['type']){
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

            if(empty($name)){
                echo "(Obrazek nie został zmieniony.)";
            }else{
                $size = $_FILES['filename']['size'];
                if($size > 524288){
                    echo "Obrazek jest za duży. Maxymalna wielkość to 500kb.";
                }else{
                    if($ext){
                        $n = "uploads/$post_id.$ext";
                        move_uploaded_file($_FILES['filename']['tmp_name'], $n);
                        $thumbnail = $n;
                    }else{
                        echo "Nieprawidłowe rozszerzenie! ('$name')";
                    }
                }
            }
        }

        $post_title = strtoupper($_POST['post_title']);
        $post_content = nl2br($_POST['post_content']);
        $post_author = $_SESSION['username'];
        $post_category = $_POST['post_category'];
        $tags = $_POST['tags'];

        if(empty($thumbnail)){
            $thumbnail = 'css/images/image-missing.jpg';
        }

        if(empty($post_title) || empty($post_content) || empty($post_author) || empty($post_category) || empty($tags)){

            echo '<div class="red-message">Proszę wypełnić wszystkie pola.</div>';

        }elseif(!empty($post_title) && !empty($post_content) && !empty($post_author) && !empty($post_category) && !empty($tags)){

            $query = mysql_query("SELECT * FROM `posts` ORDER BY `post_id` DESC LIMIT 1");

            while($row = mysql_fetch_array($query)){
                $post_id = $row['post_id'] + 1;
            }

            mysql_query("INSERT INTO `posts` VALUES ('', '$post_title', '$post_content', '$post_author', CURRENT_TIMESTAMP, 1, '$post_category', '$thumbnail', 'pl', '$tags')") or die ('Wystapi&#322; b&#322;&#261;d. Prosz&#281; spr&#243;bowa&#263; ponownie za kilka minut.');
            echo '<div class="green-message">Post wrzucony. Mo&#380;esz go obejrze&#263; klikaj&#261;c na ten link: <a href="/?post_id='.$post_id.'">http://www.gaming-passion.eu/?post_id='.$post_id.'</a></div>';

        }else{

            echo '<div class="red-message">Wystapi&#322; b&#322;&#261;d. Prosz&#281; spr&#243;bowa&#263; ponownie za kilka minut.</div>';

        }
    }

    function receivedMessages($connection){
        $user = $_SESSION['username'];
        $data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `to` = '$user' AND `active` = 1 ORDER BY `message_id` DESC LIMIT 5");
        $message_count = 0;

        while($row = mysqli_fetch_array($data)){
            $message_id = $row['message_id'];
            $title = $row['title'];
            $from = $row['from'];
            $to = $row['to'];
            $content = $row['content'];
            $read = $row['read'];
            $timestamp = strtotime($row['timestamp']);
            $date =  date('d.m.Y', $timestamp);
            $time = date('G:i', $timestamp);
            $hours_ago = intval((time() - $timestamp) / 3600);
            $days_ago = intval((time() - $timestamp) / 86400);
            $years_ago = intval(((time() - $timestamp) / 86400) / 365);

            if($hours_ago < 1){
                $hours_ago = 'less than an hour ago';
            }elseif($hours_ago == 1){
                $hours_ago = $hours_ago.' hour ago';
            }elseif($hours_ago < 5){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 5 && $hours_ago < 22){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 22 && $hours_ago < 24){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 24 && $days_ago == 1){
                $hours_ago = $days_ago.' day ago';
            }elseif($days_ago > 1){
                $hours_ago = $days_ago.' days ago';
            }elseif($days_ago > 365 && $years_ago >= 1){
                $hours_ago = $years_ago.' year ago';
            }elseif($years_ago > 1){
                $hours_ago = $years_ago.' years ago';
            }

            if($read == 0){
                $message_read_status = '<span style="float:right;"><a href="read-message.php?message_id='.$message_id.'"><img src="css/images/message-not-read.png" title="Mark as read." /></a></span>';
            }elseif($read == 1){
                $message_read_status = '<span style="float:right;"><img src="css/images/message-read.png" title="Marked as read."/></span>';
            }

            echo '
				<div class="inbox-post">
					<span style="float:right;"><a href="delete-message.php?message_id='.$message_id.'"><img src="css/images/popup-close-icon.png" title="Delete" /></a></span>
					'.$message_read_status.'
					<div class="holder"></div>
					Title: <strong>'.substr($title, 0, 25).'</strong>
					<div class="message-info">From: <a href="profile.php?user='.$from.'"><strong>'.$from.'</strong></a></div>
					<div class="message-info">To: <a href="profile.php?user='.$to.'"><strong>'.$to.'</strong></a></div>
					<div class="message-info" style="margin-bottom:5px;">Sent: <strong>'.$date.'</strong> at <strong>'.$time.'</strong> ('.$hours_ago.')</div>
					<div class="message-info"><span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">'.substr($content, 0, 152).'</span></div>
				</div>
				';
            $message_count++;
        }

        if($message_count == 0){
            echo '<div class="inbox-post"><center>Your inbox is empty.</center></div>';
        }
    }
    function receivedMessagesFull($connection){
        $user = $_SESSION['username'];
        $data = mysqli_query($connection, "SELECT * FROM `private_messages` WHERE `to` = '$user' AND `active` = 1 ORDER BY `message_id` DESC");
        $message_count = 0;

        while($row = mysqli_fetch_array($data)){
            $message_id = $row['message_id'];
            $title = $row['title'];
            $from = $row['from'];
            $to = $row['to'];
            $content = $row['content'];
            $read = $row['read'];
            $timestamp = strtotime($row['timestamp']);
            $date =  date('d.m.Y', $timestamp);
            $time = date('G:i', $timestamp);
            $hours_ago = intval((time() - $timestamp) / 3600);
            $days_ago = intval((time() - $timestamp) / 86400);
            $years_ago = intval(((time() - $timestamp) / 86400) / 365);

            if($hours_ago < 1){
                $hours_ago = 'less than an hour ago';
            }elseif($hours_ago == 1){
                $hours_ago = $hours_ago.' hour ago';
            }elseif($hours_ago < 5){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 5 && $hours_ago < 22){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 22 && $hours_ago < 24){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 24 && $days_ago == 1){
                $hours_ago = $days_ago.' day ago';
            }elseif($days_ago > 1){
                $hours_ago = $days_ago.' days ago';
            }elseif($days_ago > 365 && $years_ago >= 1){
                $hours_ago = $years_ago.' year ago';
            }elseif($years_ago > 1){
                $hours_ago = $years_ago.' years ago';
            }

            if($read == 0){
                $message_read_status = '<span style="float:right;"><a href="read-message.php?message_id='.$message_id.'"><img src="css/images/message-not-read.png" title="Mark as read." /></a></span>';
            }elseif($read == 1){
                $message_read_status = '<span style="float:right;"><img src="css/images/message-read.png" title="Marked as read."/></span>';
            }

            echo '
				<div class="inbox-post">
					<span style="float:right;"><a href="delete-message.php?message_id='.$message_id.'"><img src="css/images/popup-close-icon.png" title="Delete" /></a></span>
					'.$message_read_status.'
					<div class="holder"></div>
					Title: <strong>'.$title.'</strong>
					<div class="message-info">From: <a href="profile.php?user='.$from.'"><strong>'.$from.'</strong></a></div>
					<div class="message-info">To: <a href="profile.php?user='.$to.'"><strong>'.$to.'</strong></a></div>
					<div class="message-info" style="margin-bottom:5px;">Sent: <strong>'.$date.'</strong> at <strong>'.$time.'</strong> ('.$hours_ago.')</div>
					<div class="message-info"><span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">'.$content.'</span></div>
				</div>
				';
            $message_count++;
        }

        if($message_count == 0){
            echo '<div class="inbox-post"><center>Your inbox is empty.</center></div>';
        }
    }
    function sentMessages(){
        $user = $_SESSION['username'];
        $data = mysql_query("SELECT * FROM `private_messages` WHERE `from` = '$user' AND `active_from` = 1 ORDER BY `message_id` DESC LIMIT 5");
        $message_count_sent = 0;

        while($row = mysql_fetch_array($data)){
            $message_id = $row['message_id'];
            $title = $row['title'];
            $from = $row['from'];
            $to = $row['to'];
            $content = $row['content'];
            $read = $row['read'];
            $timestamp = strtotime($row['timestamp']);
            $date =  date('d.m.Y', $timestamp);
            $time = date('G:i', $timestamp);
            $hours_ago = intval((time() - $timestamp) / 3600);
            $days_ago = intval((time() - $timestamp) / 86400);
            $years_ago = intval(((time() - $timestamp) / 86400) / 365);

            if($hours_ago < 1){
                $hours_ago = 'less than an hour ago';
            }elseif($hours_ago == 1){
                $hours_ago = $hours_ago.' hour ago';
            }elseif($hours_ago < 5){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 5 && $hours_ago < 22){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 22 && $hours_ago < 24){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 24 && $days_ago == 1){
                $hours_ago = $days_ago.' day ago';
            }elseif($days_ago > 1){
                $hours_ago = $days_ago.' days ago';
            }elseif($days_ago > 365 && $years_ago >= 1){
                $hours_ago = $years_ago.' year ago';
            }elseif($years_ago > 1){
                $hours_ago = $years_ago.' years ago';
            }

            if($read == 0){
                $message_read_status = '<span style="float:right;"><img src="css/images/message-not-read.png" title="Not read." /></span>';
            }elseif($read == 1){
                $message_read_status = '<span style="float:right;"><img src="css/images/message-read.png" title="Read."/></span>';
            }

            echo '
				<div class="inbox-post">
					<span style="float:right;"><a href="delete-message.php?message_id='.$message_id.'"><img src="css/images/popup-close-icon.png" title="Delete" /></a></span>
					'.$message_read_status.'
					<div class="holder"></div>
					Title: <strong>'.substr($title, 0, 25).'</strong>
					<div class="message-info">From: <a href="profile.php?user='.$from.'"><strong>'.$from.'</strong></a></div>
					<div class="message-info">To: <a href="profile.php?user='.$to.'"><strong>'.$to.'</strong></a></div>
					<div class="message-info" style="margin-bottom:5px;">Sent: <strong>'.$date.'</strong> at <strong>'.$time.'</strong> ('.$hours_ago.')</div>
					<div class="message-info"><span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">'.substr($content, 0, 152).'</span></div>
				</div>
				';
            $message_count_sent++;
        }

        if($message_count_sent == 0){
            echo '<div class="inbox-post"><center>You didn\'t send any messages yet.</center></div>';
        }
    }
    function sentMessagesFull(){
        $user = $_SESSION['username'];
        $data = mysql_query("SELECT * FROM `private_messages` WHERE `from` = '$user' AND `active_from` = 1 ORDER BY `message_id` DESC");
        $message_count_sent = 0;

        while($row = mysql_fetch_array($data)){
            $message_id = $row['message_id'];
            $title = $row['title'];
            $from = $row['from'];
            $to = $row['to'];
            $content = $row['content'];
            $read = $row['read'];
            $timestamp = strtotime($row['timestamp']);
            $date =  date('d.m.Y', $timestamp);
            $time = date('G:i', $timestamp);
            $hours_ago = intval((time() - $timestamp) / 3600);
            $days_ago = intval((time() - $timestamp) / 86400);
            $years_ago = intval(((time() - $timestamp) / 86400) / 365);

            if($hours_ago < 1){
                $hours_ago = 'less than an hour ago';
            }elseif($hours_ago == 1){
                $hours_ago = $hours_ago.' hour ago';
            }elseif($hours_ago < 5){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 5 && $hours_ago < 22){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 22 && $hours_ago < 24){
                $hours_ago = $hours_ago.' hours ago';
            }elseif($hours_ago >= 24 && $days_ago == 1){
                $hours_ago = $days_ago.' day ago';
            }elseif($days_ago > 1){
                $hours_ago = $days_ago.' days ago';
            }elseif($days_ago > 365 && $years_ago >= 1){
                $hours_ago = $years_ago.' year ago';
            }elseif($years_ago > 1){
                $hours_ago = $years_ago.' years ago';
            }

            if($read == 0){
                $message_read_status = '<span style="float:right;"><img src="css/images/message-not-read.png" title="Not read." /></span>';
            }elseif($read == 1){
                $message_read_status = '<span style="float:right;"><img src="css/images/message-read.png" title="Read."/></span>';
            }

            echo '
				<div class="inbox-post">
					<span style="float:right;"><a href="delete-message.php?message_id='.$message_id.'"><img src="css/images/popup-close-icon.png" title="Delete" /></a></span>
					'.$message_read_status.'
					<div class="holder"></div>
					Title: <strong>'.$title.'</strong>
					<div class="message-info">From: <a href="profile.php?user='.$from.'"><strong>'.$from.'</strong></a></div>
					<div class="message-info">To: <a href="profile.php?user='.$to.'"><strong>'.$to.'</strong></a></div>
					<div class="message-info" style="margin-bottom:5px;">Sent: <strong>'.$date.'</strong> at <strong>'.$time.'</strong> ('.$hours_ago.')</div>
					<div class="message-info"><span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">'.$content.'</span></div>
				</div>
				';
            $message_count_sent++;
        }

        if($message_count_sent == 0){
            echo '<div class="inbox-post"><center>You didn\'t send any messages yet.</center></div>';
        }
    }
}
?>