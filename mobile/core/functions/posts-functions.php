<?php
function savePost(){
	$post_title = $_POST['post_title'];
	$post_content = $_POST['post_content'];
	$post_author = $_POST['post_author'];
	$post_category = $_POST['post_category'];
	$thumbnail = $_POST['thumbnail'];
	$tags = $_POST['tags'];
	
	if(empty($post_title) || empty($post_content) || empty($post_author) || empty($post_category) || empty($tags)){
		
		echo '<div class="red-message">Prosz&#281; wype&#322;ni&#263; wszystkie pola.</div>';
		
	}elseif(!empty($post_title) && !empty($post_content) && !empty($post_author) && !empty($post_category) && !empty($tags)){		
	
		$query = mysql_query("SELECT * FROM `posts` ORDER BY `post_id` DESC LIMIT 1");
		
		while($row = mysql_fetch_array($query)){
			$post_id = $row['post_id'] + 1;
		}
			
		mysql_query("INSERT INTO `posts` VALUES ('', '$post_title', '$post_content', '$post_author', CURRENT_TIMESTAMP, 1, '$post_category', '$thumbnail', 'pl', '$tags')") or die ('Wystapi&#322; b&#322;&#261;d. Prosz&#281; spr&#243;bowa&#263; ponownie za kilka minut.');
		echo '<div class="green-message">Post wrzucony. Mo&#380;esz go obejrze&#263; klikaj&#261;c na ten link: <a href="/article/?post_id='.$post_id.'">http://www.gaming-passion.eu/article/?post_id='.$post_id.'</a></div>';
		
	}else{
	
		echo '<div class="red-message">Wystapi&#322; b&#322;&#261;d. Prosz&#281; spr&#243;bowa&#263; ponownie za kilka minut.</div>';	
		
	}
}
function showNewPost(){
	$data = mysql_query("SELECT * FROM `posts` WHERE section = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 1");
	$post_count = 0;
	$comment_count = 0;
		
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="post">
					<a href="/article/?id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<span class="post-image" style="background-image:url('.$thumbnail.'); "></span>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
}
function showAllPosts(){
	$data = mysql_query("SELECT * FROM `posts` WHERE section = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 1, 10");
	$post_count = 0;
	$comment_count = 0;
		
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="small-post">
					<a href="/article/?id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<div class="small-post-image" style="background-image:url('.$thumbnail.'); "></div>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>
				';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
	echo '
		<div class="holder"></div>
		<div style="padding:20px; width:95%; font:18px Arial;">
			<i>
				<a href="/archive">
						Archiwum
				</a>
			</i>
		</div>';
}
function showNewsPosts(){
	$data = mysql_query("SELECT * FROM `posts` WHERE `post_category` = 'news' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10");
	$post_count = 0;
	$comment_count = 0;
	
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="small-post">
					<a href="/article/?post_id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<div class="small-post-image" style="background-image:url('.$thumbnail.'); "></div>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>
				';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
	echo '
		<div class="holder"></div>
		<div style="padding:20px; width:95%; font:18px Arial;">
			<i>
				<a href="/archive">
						Archiwum
				</a>
			</i>
		</div>';
}
function showReviewPosts(){
	$data = mysql_query("SELECT * FROM `posts` WHERE `post_category` = 'recenzja' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10");
	$post_count = 0;
	$comment_count = 0;
	
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="small-post">
					<a href="/article/?post_id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<div class="small-post-image" style="background-image:url('.$thumbnail.'); "></div>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>
				';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
	echo '
		<div class="holder"></div>
		<div style="padding:20px; width:95%; font:18px Arial;">
			<i>
				<a href="/archive">
						Archiwum
				</a>
			</i>
		</div>';
}
function showGuidePosts(){
	$data = mysql_query("SELECT * FROM `posts` WHERE `post_category` = 'poradnik' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10"); 
	$post_count = 0;
	$comment_count = 0;
	
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="small-post">
					<a href="/article/?post_id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<div class="small-post-image" style="background-image:url('.$thumbnail.'); "></div>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>
				';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
	echo '
		<div class="holder"></div>
		<div style="padding:20px; width:95%; font:18px Arial;">
			<i>
				<a href="/archive">
						Archiwum
				</a>
			</i>
		</div>';
}
function showGameplayPosts(){
	$data = mysql_query("SELECT * FROM `posts` WHERE `post_category` = 'gameplay' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10"); 
	$post_count = 0;
	$comment_count = 0;
	
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="small-post">
					<a href="/article/?post_id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<div class="small-post-image" style="background-image:url('.$thumbnail.'); "></div>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>
				';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
	echo '
		<div class="holder"></div>
		<div style="padding:20px; width:95%; font:18px Arial;">
			<i>
				<a href="/archive">
						Archiwum
				</a>
			</i>
		</div>';
}
function showArchivePosts(){
	$data = mysql_query("SELECT * FROM `posts` WHERE `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10, 18446744073709551615"); 
	$post_count = 0;
	
	while($row = mysql_fetch_array($data)){
		
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_content = $row['post_content'];
		$post_count++;
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		if(strlen($post_content) > 255){
			$end = '<a href="/article/?id='.$post_id.'">(czytaj dalej / skomentuj)</a>';
		}else{
			$end = '<a href="/article/?id='.$post_id.'">(skomentuj)</a>';
		}

		if($public == 1){
			echo '
				<div class="small-post">
					<a href="/article/?post_id='.$post_id.'">
						<span class="post-h2">'.strtoupper($post_title).'</span>
					</a>
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">'.$post_author.'</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
								</td>
							</tr>
						</table>
					</h6>
					<a href="/article/?id='.$post_id.'">
						<div class="small-post-image" style="background-image:url('.$thumbnail.'); "></div>
					</a>
					<p>
						'.substr($post_content, 0,255).'...
					</p>
					<p style="float:right;">
						'.$end.'
					</p>
					<div class="holder"></div>
				</div>
				';
		}
		$comment_count = 0;
	}
	if($post_count == 0){
		echo '<center><h2>Obecnie nie ma zadnych postow w naszej bazie danych.</h2></center>';	
	}
}
function showOnePost(){
	if(isset($_GET['id'])){
		$post_id = $_GET['id'];
	}elseif(isset($_GET['post_id'])){
		$post_id = $_GET['post_id'];
	}
	
	$data2 = mysql_query("SELECT * FROM `posts` ORDER BY post_id DESC LIMIT 1");
	
	while($row2 = mysql_fetch_array($data2)){
		$top_post_id = $row2['post_id'];		
	}
	
	if($post_id > $top_post_id || $post_id < 0){
		echo '<center><h1>Taki post nie istnieje!</h1><br /><p><a href="http://www.gaming-passion.eu/">Wr&#243;&#263; na Stron&#281; G&#322;&#243;wna.</a></p></center>';
	}
	
	$data = mysql_query("SELECT * FROM `posts` WHERE post_id = $post_id");	
	$comment_count = 0;
	
	while($row = mysql_fetch_array($data)){
		$timestamp = strtotime($row['timestamp']);
		$date =  date('d.m.Y', $timestamp);
		$time = date('G:i', $timestamp);
		$public = $row['public'];
		$thumbnail = $row['thumbnail'];
		$post_content = $row['post_content'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];

		$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");
		
		while($comment_row = mysql_fetch_array($comment_data)){
			$comment_count++;
		}

		if(empty($thumbnail)){
			$thumbnail = '../css/images/image-missing.png';	
		}
		
		$user = $_SESSION['username'];
		$data = mysql_query("SELECT * FROM `comments` WHERE `comment_author` = '$user' ORDER BY timestamp DESC LIMIT 1");
		
		while($row = mysql_fetch_array($data)){
			$last_comment_time = $row['timestamp'];
		}
		
		$last_comment_time = strtotime($last_comment_time);
		$today = time();

		$time_difference = $today - $last_comment_time;
		
		$time_difference = 300 - $time_difference;
		
		$minutes = intval(date('i', $time_difference));
		$seconds = intval(date('s', $time_difference));
		
		if($public == 1){
				if(isset($_GET['success'])){
					echo '<div class="green-message"><table><tr><td style="padding-right:5px;"><img src="../css/images/popup-info-icon.png" /></td><td>Twoj komentarz został pomyślnie dodany.</td></tr></table></div>';
				}
				if(isset($_GET['fields-not-set'])){
					echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="../css/images/popup-info-icon.png" /></td><td>Proszę wypełnić wszystkie pola.</td></tr></table></div>';
				}
				if(isset($_GET['bot-alert'])){
					echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="../css/images/popup-info-icon.png" /></td><td>Wydaje nam się, że jesteś botem. Prosimy spróbować ponownie.</td></tr></table></div>';
				}
				if(isset($_GET['time'])){
					echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="../css/images/popup-info-icon.png" /></td><td>Nie tak szybko! Możesz dodać kolejny komentarz za <strong>'.$minutes.'</strong> minut i <strong>'.$seconds.'</strong> sekund.</td></tr></table></div>';
				}
				
				if($row['post_category'] == 'news'){
					$category = 'news';
				}elseif($row['post_category'] == 'recenzja'){
					$category = 'reviews';
				}elseif($row['post_category'] == 'gameplay'){
					$category = 'gameplay';
				}
				
		
		echo '
			<div class="floating-like-box">
				<h4>PODZIEL SIĘ!</h4>
				<div class="like-object">
					<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fgaming-passion.eu%2Findex.php%3Fpost_id%3D'.$row['post_id'].'&amp;send=false&amp;layout=button_count&amp;width=75&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:95px; height:21px;" allowTransparency="true"></iframe>
				</div>
				<div class="like-object">
					<a href="#"
					  onclick="
						window.open(
						  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
						  \'facebook-share-dialog\', 
						  \'width=626,height=436\'); 
						return false;"><img src="../css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
				</div>
				<div class="like-object">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://gaming-passion.eu/index.php?post_id='.$row['post_id'].'" data-text="'.$row['post_title'].'" data-via="GamingPassionPL">Tweet</a>
				</div>
				<div class="like-object">
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
					<div class="g-plusone" data-size="medium" data-href="http://gaming-passion.eu/index.php?post_id='.$row['post_id'].'"></div>
					<script type="text/javascript">
					  window.___gcfg = {lang: \'en-GB\'};
					
					  (function() {
						var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
						po.src = \'https://apis.google.com/js/plusone.js\';
						var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div>
			</div>
			<p>
				Jesteś tutaj: <a href="../">Strona Główna</a> > <a href="../'.$category.'">'.ucfirst($row['post_category']).'</a> > <a href="../article/?id='.$post_id.'">'.strtoupper($post_title).'</a>
			</p>
			<div class="holder"></div>
			<div class="post" style="border-bottom:none;">
				<span class="post-image" style="background-image:url('.$thumbnail.'); margin-right:10px;">
				<img src="'.$thumbnail.'" style="visibility:hidden;" /></span>
				<h2 style="text-align:left;" class="one-post-h1">'.strtoupper($post_title).'</h2>
				<div class="icons-one-post">
					<h6>
						<table>
							<tr>
								<td>
									<img src="../css/images/post-icon-user.jpg" width="15" style="border:none;" title="Dodane przez"/>
								</td>
								<td>
									<a href="http://gaming-passion.eu/profile/?user='.$post_author.'">
										'.$post_author.'
									</a>
								</td>
								<td>
									<img src="../css/images/post-icon-category.jpg" width="15" style="border:none;" title="Kategoria" />
								</td>
								<td>
									'.ucfirst($row['post_category']).'
								</td>
								<td>
									<img src="../css/images/post-icon-calendar.jpg" width="15" style="border:none;" title="Dodano" />
								</td>
								<td>
									'.$date.'
								</td>
								<td>
									<img src="../css/images/post-icon-comments.jpg" width="15" style="border:none;" title="Komentarzy" />
								</td>
								<td>
									'.$comment_count.'
								</td>
							</h6>
						</tr>
					</table>
				</div>
				<p>'.$post_content.'</p>
			</div>
			<div class="holder"></div>
			<h2 style="border-bottom:2px solid #ccc;">Tagi</h2>
			';
				$tags_data = mysql_query("SELECT * FROM `posts` WHERE post_id = '$post_id'");
				while($tags_row = mysql_fetch_array($tags_data)){
						$tags = explode(", ", $tags_row['tags']);
						$a = count($tags);
						$b = 0;
						for($i = 0; $i < $a; $i++){
							echo '<span class="tag">'.strtolower($tags[$b]).'</span>';
							$b++;
						}
				}
			echo '
				<div class="holder"></div>
				<br />
				<h2 style="border-bottom:2px solid #ccc;">Komentarze</h2>
				'; ?>
			<?php			
				$post_id = $_GET['id'];
                $comment_data = mysql_query("SELECT * FROM `comments` WHERE `comment_post_id` = '$post_id' AND `active` = 1 ORDER BY timestamp DESC");
				$comment_count = 0;
				while($comment_row = mysql_fetch_array($comment_data)){
					$timestamp = strtotime($comment_row['timestamp']);
					$date =  date('d.m.Y', $timestamp);
					$time = date('G:i', $timestamp);
					$comment_count++;
					if($comment_row['comment_author_status'] == 'admin'){
						$color = '#FF0000';
					}elseif($comment_row['comment_author_status'] == 'mod'){
						$color = '#0000FF';
					}elseif($comment_row['comment_author_status'] == 'user'){
						$color = '#333';
					}else{
						$color = '#333';	
					}
					
					echo '
					<div class="post-comment">
						<i><strong><a href="/profile/?user='.$comment_row['comment_author'].'" class="comment-author-link" style="color:'.$color.';">'.$comment_row['comment_author'].'</a></strong> o <strong>'.$time.' - '.$date.'</strong></i><br /><br />
						<span style="padding:10px; font:13px Arial;">'.$comment_row['comment_content'].'</span>
					</div>';
				}
				if($comment_count == 0 ){
					echo '<div class="post-comment"><center><h3>Obecnie brak komentarzy pod tym postem.</h3></center></div>';	
				}

                if(loggedIn() == true){
                   if(adminUser() == true){
                        echo '<br />
					<h2 style="border-bottom:2px solid #ccc;">Dodaj Komentarz</h2>
					<div class="form-table">
						<center>
							<form action="comment-check.php" method="post">
								<table>
									<tr>
										<td>Komentarz:</td><td><textarea name="comment-content" style="width:400px; height:100px;"></textarea></td>
									</tr>
									<tr>
										<td>Jaka jest stolica Polski?</td>
										<td style="text-align:left;">
											<input type="text" name="bot-check" class="text-field" />
											<input type="text" name="comment_author_status" value="admin" style="visibility:hidden; width:0px; height:0px;" />
											<input type="text" name="post_id" value="'.$_GET['id'].'" style="visibility:hidden; width:0px; height:0px;" />
										<td>

									</tr>
									<tr>
										<td colspan="2"><center><input type="submit" value="Wyślij" class="button" /></center></td>
									</tr>
								</table>
							</form>
						</center>
					</div>
                        ';
                    }elseif(modUser() == true){
                        echo '<br />
					<h2 style="border-bottom:2px solid #ccc;">Dodaj Komentarz</h2>
					<div class="form-table">
						<center>
							<form action="comment-check.php" method="post">
								<table>
									<tr>
										<td>Komentarz:</td><td><textarea name="comment-content" style="width:400px; height:100px;"></textarea></td>
									</tr>
									<tr>
										<td>Jaka jest stolica Polski?</td>
										<td style="text-align:left;">
											<input type="text" name="bot-check" class="text-field" />
											<input type="text" name="comment_author_status" value="mod" style="visibility:hidden; width:0px; height:0px;" />
											<input type="text" name="post_id" value="'.$_GET['id'].'" style="visibility:hidden; width:0px; height:0px;" />
										<td>

									</tr>
									<tr>
										<td colspan="2"><center><input type="submit" value="Wyślij" class="button" /></center></td>
									</tr>
								</table>
							</form>
						</center>
					</div>
                        ';
                    }elseif(!adminUser() && !modUser()){
                        echo '<br />
					<h2 style="border-bottom:2px solid #ccc;">Dodaj Komentarz</h2>
					<div class="form-table">
						<center>
							<form action="comment-check.php" method="post">
								<table>
									<tr>
										<td>Komentarz:</td><td><textarea name="comment-content" style="width:400px; height:100px;"></textarea></td>
									</tr>
									<tr>
										<td>Jaka jest stolica Polski?</td>
										<td style="text-align:left;">
											<input type="text" name="bot-check" class="text-field" />
											<input type="text" name="comment_author_status" value="user" style="visibility:hidden; width:0px; height:0px;" />
											<input type="text" name="post_id" value="'.$_GET['id'].'" style="visibility:hidden; width:0px; height:0px;" />
										<td>

									</tr>
									<tr>
										<td colspan="2"><center><input type="submit" value="Wyślij" class="button" /></center></td>
									</tr>
								</table>
							</form>
						</center>
					</div>
                        ';
					}
                }else{
                    echo '
					<div class="not-logged-in-comment"><br />
						<h2 style="border-bottom:2px solid #ccc;">Dodaj Komentarz</h2><br />
						<p>
							Musisz się <a href="../login.php"><span style="color:#0093D9;" class="underline_link">zalogować</span></a>, aby móc dodać komentarz.<br />
							Nie masz konta? <a href="../register.php"><span style="color:#0093D9;" class="underline_link">Zarejestruj</span></a> się za darmo!
						</p>
					</div>
                    ';	
                }
		}else{
			echo '<p><a href="index.php">< Strona G&#322;&#243;wna</a></p><center><h1>Ten post nie jest publiczny.</h1></center>';	
		}
	}
}
?>