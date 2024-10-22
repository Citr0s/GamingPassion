<?php
	include_once '../core/bootstrap.php';

	$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$length = 5;
	$newName = '';

	for($i = 0; $i < $length; $i++){
	    $newName .= $chars[mt_rand(0, 36)];
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
			echo "(Thumbnail was not changed.)";
		}else{
			$size = $_FILES['filename']['size'];
			if($size > 524288){
				echo "Image is too big. Max size is 500Kb.";
			}else{
				if($ext){
					$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
					$length = 5;
					$newName = '';

					for($i = 0; $i < $length; $i++){
					    $newName .= $chars[mt_rand(0, 36)];
					}
					
					$n = "uploads/".$newName.".".$ext;
					$thumbnail = "uploads/".$newName.".".$ext;
					if(move_uploaded_file($_FILES['filename']['tmp_name'], $n)){
                        echo 'Uploaded';
                    }else{
                        echo 'Problem with uploading.';
                        //die();
                    }
				}else{
					echo "Unsupported extension! ('$name')";
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
		$thumbnail = '/assets/images/image-missing.jpg';
	}
	
	if(empty($post_title) || empty($post_content) || empty($post_author) || empty($post_category) || empty($tags)){
		
		echo '<div class="red-message">All fields are required.</div>';
		
	}elseif(!empty($post_title) && !empty($post_content) && !empty($post_author) && !empty($post_category) && !empty($tags)){
			
		mysqli_query($connection, "INSERT INTO `posts` VALUES ('', '$post_title', 'test', '$post_author', CURRENT_TIMESTAMP, 1, '$post_category', '$thumbnail', 'pl', '$tags')") or die ('Something went wrong. Please try again later.');
		echo 'OK GO';
		echo '
			<script>
				window.location = "//dashboard/articles.php?success";
			</script>
		';
		
	}else{
	
		echo '<div class="red-message">Something went wrong. Please try again later. (2)</div>';	
		
	}
?>