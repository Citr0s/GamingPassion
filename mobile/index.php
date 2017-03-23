<?php include 'core/init.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<link rel="icon" href="../css/images/favicon.ico?v=2" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Gaming-Passion.com | Bo Gry to Nasza Pasja!" />
<meta name="keywords" content="gaming, passion, gry, to, nasza, pasja" />
<title>Gaming-Passion.com | Bo Gry to Nasza Pasja!</title>
</head>
<body>
    	<div id="header">
    	   	<div id="main-logo">
	        	<a href="/"><img src="css/images/main-logo.jpg" alt="main logo" /></a>
            </div>
        </div>
    	<div id="main-content">
<?php
		if(isset($_GET['post_id'])){
?>
		<?php
			$post_id = $_GET['post_id'];
            $data = mysql_query("SELECT * FROM `posts` WHERE post_id = $post_id ORDER BY post_id LIMIT 1"); 
            $post_count = 0;
            
            while($row = mysql_fetch_array($data)){
                
                $timestamp = strtotime($row['timestamp']);
                $date =  date('d/m/Y', $timestamp);
                $time = date('G:i', $timestamp);
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_content = $row['post_content'];
                $post_count++;
                $public = $row['public'];
                $thumbnail = $row['thumbnail'];
        
                if(empty($thumbnail)){
                    $thumbnail = 'http://miloszdura.com/techblog/css/images/image-missing.png';	
                }
        
                if($public == 1){
                    echo '<div class="post-small"><a href="http://miloszdura.com/techblog/mobile/"><h2>< BACK</h2></a><img src="http://miloszdura.com/techblog/'.$thumbnail.'" style="width:100%; border:1px solid #666;" /><br /><h3>'.$post_title.'</h3><p>'.$post_content.'</p><br /><a href="http://miloszdura.com/techblog/mobile/"><h2>< BACK</h2></a></div>';
                }
            }
            if($post_count == 0){
                echo '<center><h1>Currently there are no posts in our database.</h1></center>';
            }
?>
<?php
		}elseif(!isset($_GET['post_id'])){
?>
        <a href="http://miloszdura.com/techblog/mobile/"><h1 style="font:4em Arial;">10 NEWEST ARTICLES</h1></a>
		<?php
            $data = mysql_query("SELECT * FROM `posts` WHERE `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10"); 
            $post_count = 0;
            
            while($row = mysql_fetch_array($data)){
                
                $timestamp = strtotime($row['timestamp']);
                $date =  date('d/m/Y', $timestamp);
                $time = date('G:i', $timestamp);
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_content = $row['post_content'];
                $post_count++;
                $public = $row['public'];
                $thumbnail = $row['thumbnail'];

                $post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 152));
        
                if(empty($thumbnail)){
                    $thumbnail = '../css/images/image-missing.png';	
                }
        
                if($public == 1){
                    echo '<div class="post-small"><a href="?post_id='.$post_id.'"><img src="http://miloszdura.com/techblog/'.$thumbnail.'" style="width:100%; border:1px solid #666; /></a><a href="?post_id='.$post_id.'"><br /><h3 style="text-align:left;">'.strtoupper($post_title).'</h3></a><p>'.$post_content.'&nbsp;<a href="?post_id='.$post_id.'" style="font-weight:bold; float:right;"><br />(Read full post)</a><div class="holder"></div></p><br /></div>';
                }
            }
            if($post_count == 0){
                echo '<center><h1 style="font:4em Arial;">Currently there are no posts in our database.</h1></center>';
            }
		}
        ?>
        </div>
    	<div id="footer">
			<h6>&copy; Copyright 2013 - 2014 <a href="http://miloszdura.com/techblog/">Gaming Passion</a> Designed and Developed by <a href="http://www.miloszdura.com/">Milosz Dura</a></h6>
        </div>
</body>
</html>