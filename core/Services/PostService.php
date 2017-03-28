<?php namespace GamingPassion\Services;

use GamingPassion\Database;

class PostService
{
    private $database;

    function __construct(Database $database)
    {
    	$this->database = $database;
    }

	public function getAll(){
        return  $this->database->getAllPosts();
	}

	function showNewsPosts($connection){
		$data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'news' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10");
		$post_count = 0;
		$comment_count = 0;

		while($row = mysqli_fetch_array($data)){
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
			$hours_ago = intval((time() - $timestamp) / 3600);
			$days_ago = intval((time() - $timestamp) / 86400);
			$years_ago = intval(((time() - $timestamp) / 86400) / 365);

			$day =  date('d', $timestamp);
			$month =  date('m', $timestamp);

			switch($month){
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

			$year =  date('Y', $timestamp);

			$comment_data = mysqli_query($connection, "SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

			while($comment_row = mysqli_fetch_array($comment_data)){
				$comment_count++;
			}

			if(empty($thumbnail)){
				$thumbnail = 'css/images/image-missing.png';
			}

			$total_ratings = 0;
			$total_score = 0;
			$datax = mysqli_query($connection, "SELECT * FROM `ratings` WHERE `post_id` = $post_id");
			while($rowx = mysqli_fetch_array($datax)){
				$rating = $rowx['rating'];
				$total_score += $rating;
				$total_ratings++;
			}

			if($total_ratings != 0){
				$average_rating = round($total_score / $total_ratings, 1);
				settype($average_rating, 'float');
			}

			if(loggedIn() && notVoted($connection, $post_id)){
				$rating = '
					<div class="stars-bg">
						<a href="vote.php?post_id='.$post_id.'&rating=1"><div class="star-1"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=2"><div class="star-2"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=3"><div class="star-3"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=4"><div class="star-4"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=5"><div class="star-5"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=6"><div class="holder"></div></a>
					</div>
				';
			}else{
				if($total_score <= 0){
					$rating = '<img src="css/images/rating-0-stars.png" title="'.$total_score.'/5" />';
				}elseif($average_rating <= 1){
					$rating = '<img src="css/images/rating-1-star.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 2){
					$rating = '<img src="css/images/rating-2-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 3){
					$rating = '<img src="css/images/rating-3-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 4){
					$rating = '<img src="css/images/rating-4-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 5){
					$rating = '<img src="css/images/rating-5-stars.png" title="'.$average_rating.'/5" />';
				}
			}

			if($public == 1){
				$post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 255));
				echo '
					<div class="post">
						<div class="post-title"><a href="?id='.$post_id.'">'.strtoupper($post_title).'</a></div>
						<div class="post-social">
							<table>
								<tr>
									<td>
										<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									</td>
									<td>
										<a href="#"
										  onclick="
											window.open(
											  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
											  \'facebook-share-dialog\', 
											  \'width=626,height=436\'); 
											return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
									</td>
									<td>
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://miloszdura.com/techblog/id='.$post_id.'" data-text="'.strtoupper($post_title).'" data-via="GamingPassionPL">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
									</td>
									<td>
										<div class="g-plusone" data-size="medium" data-href="http://miloszdura.com/techblog/?id='.$post_id.'"></div>
										<script type="text/javascript">
										  window.___gcfg = {lang: \'en-GB\'};
										
										  (function() {
											var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
											po.src = \'https://apis.google.com/js/plusone.js\';
											var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>				
										</div>
									</td>
									<td>
										<table>
											<tr>
												<td>Rating:</td><td>'.$rating.'</td><td>('.$total_ratings.')</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="post-info"><a href="profile.php?user='.$post_author.'">'.$post_author.'</a> at '.$time.' on '.$day.' '.$month.' '.$year.'</div>
						<div class="post-image"><a href="?id='.$post_id.'"><img src="'.$thumbnail.'" /></a></div>
						<div class="post-sample">'.$post_content.'<div class="read-full-article"><a href="?id='.$post_id.'" class="read-full-article-hover">Read full post ></a></div></div>
					</div>';
			}
			$comment_count = 0;
		}
		if($post_count == 0){
			echo '<center><div class="empty_result">Currently there are no records in our database.</div></center>';
		}
	}
	function showReviewPosts($connection){
		$data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `post_category` = 'recenzja' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10");
		$post_count = 0;
		$comment_count = 0;

		while($row = mysqli_fetch_array($data)){
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
			$hours_ago = intval((time() - $timestamp) / 3600);
			$days_ago = intval((time() - $timestamp) / 86400);
			$years_ago = intval(((time() - $timestamp) / 86400) / 365);

			$day =  date('d', $timestamp);
			$month =  date('m', $timestamp);

			switch($month){
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

			$year =  date('Y', $timestamp);

			$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

			while($comment_row = mysql_fetch_array($comment_data)){
				$comment_count++;
			}

			if(empty($thumbnail)){
				$thumbnail = 'css/images/image-missing.png';
			}

			$total_ratings = 0;
			$total_score = 0;
			$datax = mysqli_query("SELECT * FROM `ratings` WHERE `post_id` = $post_id");
			while($rowx = mysql_fetch_array($datax)){
				$rating = $rowx['rating'];
				$total_score += $rating;
				$total_ratings++;
			}

			if($total_ratings != 0){
				$average_rating = round($total_score / $total_ratings, 1);
				settype($average_rating, 'float');
			}

			if(loggedIn() && notVoted($connection, $post_id)){
				$rating = '
					<div class="stars-bg">
						<a href="vote.php?post_id='.$post_id.'&rating=1"><div class="star-1"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=2"><div class="star-2"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=3"><div class="star-3"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=4"><div class="star-4"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=5"><div class="star-5"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=6"><div class="holder"></div></a>
					</div>
				';
			}else{
				if($total_score <= 0){
					$rating = '<img src="css/images/rating-0-stars.png" title="'.$total_score.'/5" />';
				}elseif($average_rating <= 1){
					$rating = '<img src="css/images/rating-1-star.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 2){
					$rating = '<img src="css/images/rating-2-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 3){
					$rating = '<img src="css/images/rating-3-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 4){
					$rating = '<img src="css/images/rating-4-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 5){
					$rating = '<img src="css/images/rating-5-stars.png" title="'.$average_rating.'/5" />';
				}
			}

			if($public == 1){
				$post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 255));
				echo '
					<div class="post">
						<div class="post-title"><a href="?id='.$post_id.'">'.strtoupper($post_title).'</a></div>
						<div class="post-social">
							<table>
								<tr>
									<td>
										<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									</td>
									<td>
										<a href="#"
										  onclick="
											window.open(
											  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
											  \'facebook-share-dialog\', 
											  \'width=626,height=436\'); 
											return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
									</td>
									<td>
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://miloszdura.com/techblog/id='.$post_id.'" data-text="'.strtoupper($post_title).'" data-via="GamingPassionPL">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
									</td>
									<td>
										<div class="g-plusone" data-size="medium" data-href="http://miloszdura.com/techblog/id='.$post_id.'"></div>
										<script type="text/javascript">
										  window.___gcfg = {lang: \'en-GB\'};
										
										  (function() {
											var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
											po.src = \'https://apis.google.com/js/plusone.js\';
											var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>				
										</div>
									</td>
									<td>
										<table>
											<tr>
												<td>Rating:</td><td>'.$rating.'</td><td>('.$total_ratings.')</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="post-info"><a href="profile.php?user='.$post_author.'">'.$post_author.'</a> at '.$time.' on '.$day.' '.$month.' '.$year.'</div>
						<div class="post-image"><a href="?id='.$post_id.'"><img src="'.$thumbnail.'" /></a></div>
						<div class="post-sample">'.$post_content.'<div class="read-full-article"><a href="?id='.$post_id.'" class="read-full-article-hover">Read full post ></a></div></div>
					</div>';
			}
			$comment_count = 0;
		}
		if($post_count == 0){
			echo '<center><div class="empty_result">Currently there are no records in our database.</div></center>';
		}
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
			$hours_ago = intval((time() - $timestamp) / 3600);
			$days_ago = intval((time() - $timestamp) / 86400);
			$years_ago = intval(((time() - $timestamp) / 86400) / 365);

			$day =  date('d', $timestamp);
			$month =  date('m', $timestamp);

			switch($month){
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

			$year =  date('Y', $timestamp);

			$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

			while($comment_row = mysql_fetch_array($comment_data)){
				$comment_count++;
			}

			if(empty($thumbnail)){
				$thumbnail = 'css/images/image-missing.png';
			}

			$total_ratings = 0;
			$total_score = 0;
			$datax = mysql_query("SELECT * FROM `ratings` WHERE `post_id` = $post_id");
			while($rowx = mysql_fetch_array($datax)){
				$rating = $rowx['rating'];
				$total_score += $rating;
				$total_ratings++;
			}

			if($total_ratings != 0){
				$average_rating = round($total_score / $total_ratings, 1);
				settype($average_rating, 'float');
			}

			if(loggedIn() && notVoted($connection, $post_id)){
				$rating = '
					<div class="stars-bg">
						<a href="vote.php?post_id='.$post_id.'&rating=1"><div class="star-1"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=2"><div class="star-2"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=3"><div class="star-3"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=4"><div class="star-4"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=5"><div class="star-5"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=6"><div class="holder"></div></a>
					</div>
				';
			}else{
				if($total_score <= 0){
					$rating = '<img src="css/images/rating-0-stars.png" title="'.$total_score.'/5" />';
				}elseif($average_rating <= 1){
					$rating = '<img src="css/images/rating-1-star.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 2){
					$rating = '<img src="css/images/rating-2-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 3){
					$rating = '<img src="css/images/rating-3-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 4){
					$rating = '<img src="css/images/rating-4-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 5){
					$rating = '<img src="css/images/rating-5-stars.png" title="'.$average_rating.'/5" />';
				}
			}

			if($public == 1){
				$post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 255));
				echo '
					<div class="post">
						<div class="post-title"><a href="?id='.$post_id.'">'.strtoupper($post_title).'</a></div>
						<div class="post-social">
							<table>
								<tr>
									<td>
										<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									</td>
									<td>
										<a href="#"
										  onclick="
											window.open(
											  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
											  \'facebook-share-dialog\', 
											  \'width=626,height=436\'); 
											return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
									</td>
									<td>
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://miloszdura.com/techblog/?id='.$post_id.'" data-text="'.strtoupper($post_title).'" data-via="GamingPassionPL">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
									</td>
									<td>
										<div class="g-plusone" data-size="medium" data-href="http://miloszdura.com/techblog/?id='.$post_id.'"></div>
										<script type="text/javascript">
										  window.___gcfg = {lang: \'en-GB\'};
										
										  (function() {
											var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
											po.src = \'https://apis.google.com/js/plusone.js\';
											var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>				
										</div>
									</td>
									<td>
										<table>
											<tr>
												<td>Rating:</td><td>'.$rating.'</td><td>('.$total_ratings.')</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="post-info"><a href="profile.php?user='.$post_author.'">'.$post_author.'</a> at '.$time.' on '.$day.' '.$month.' '.$year.'</div>
						<div class="post-image"><a href="?id='.$post_id.'"><img src="'.$thumbnail.'" /></a></div>
						<div class="post-sample">'.$post_content.'<div class="read-full-article"><a href="?id='.$post_id.'" class="read-full-article-hover">Read full post ></a></div></div>
					</div>';
			}
			$comment_count = 0;
		}
		if($post_count == 0){
			echo '<br /><center><h2>Obecnie nie ma żadnych postów w naszej bazie danych.</h2></center><br />';
		}
	}
	function showGameplayPosts(){
		$data = mysql_query("SELECT * FROM `posts` WHERE `post_category` = 'gameplay' AND `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10");
		$post_count = 0;
		$comment_count = 0;

		while($row = mysql_fetch_array($data)){
			$timestamp = strtotime($row['timestamp']);
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

			$day =  date('d', $timestamp);
			$month =  date('m', $timestamp);

			switch($month){
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

			$year =  date('Y', $timestamp);

			$comment_data = mysql_query("SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

			while($comment_row = mysql_fetch_array($comment_data)){
				$comment_count++;
			}

			if(empty($thumbnail)){
				$thumbnail = 'css/images/image-missing.png';
			}

			$total_ratings = 0;
			$total_score = 0;
			$datax = mysql_query("SELECT * FROM `ratings` WHERE `post_id` = $post_id");
			while($rowx = mysql_fetch_array($datax)){
				$rating = $rowx['rating'];
				$total_score += $rating;
				$total_ratings++;
			}

			if($total_ratings != 0){
				$average_rating = round($total_score / $total_ratings, 1);
				settype($average_rating, 'float');
			}

			if(loggedIn() && notVoted($connection, $post_id)){
				$rating = '
					<div class="stars-bg">
						<a href="vote.php?post_id='.$post_id.'&rating=1"><div class="star-1"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=2"><div class="star-2"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=3"><div class="star-3"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=4"><div class="star-4"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=5"><div class="star-5"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=6"><div class="holder"></div></a>
					</div>
				';
			}else{
				if($total_score <= 0){
					$rating = '<img src="css/images/rating-0-stars.png" title="'.$total_score.'/5" />';
				}elseif($average_rating <= 1){
					$rating = '<img src="css/images/rating-1-star.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 2){
					$rating = '<img src="css/images/rating-2-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 3){
					$rating = '<img src="css/images/rating-3-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 4){
					$rating = '<img src="css/images/rating-4-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 5){
					$rating = '<img src="css/images/rating-5-stars.png" title="'.$average_rating.'/5" />';
				}
			}

			if($public == 1){
				$post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 255));
				echo '
					<div class="post">
						<div class="post-title"><a href="?id='.$post_id.'">'.strtoupper($post_title).'</a></div>
						<div class="post-social">
							<table>
								<tr>
									<td>
										<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									</td>
									<td>
										<a href="#"
										  onclick="
											window.open(
											  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
											  \'facebook-share-dialog\', 
											  \'width=626,height=436\'); 
											return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
									</td>
									<td>
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://miloszdura.com/techblog/?id='.$post_id.'" data-text="'.strtoupper($post_title).'" data-via="GamingPassionPL">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
									</td>
									<td>
										<div class="g-plusone" data-size="medium" data-href="http://miloszdura.com/techblog/?id='.$post_id.'"></div>
										<script type="text/javascript">
										  window.___gcfg = {lang: \'en-GB\'};
										
										  (function() {
											var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
											po.src = \'https://apis.google.com/js/plusone.js\';
											var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>				
										</div>
									</td>
									<td>
										<table>
											<tr>
												<td>Rating:</td><td>'.$rating.'</td><td>('.$total_ratings.')</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="post-info"><a href="profile.php?user='.$post_author.'">'.$post_author.'</a> at '.$time.' on '.$day.' '.$month.' '.$year.'</div>
						<div class="post-image"><a href="?id='.$post_id.'"><img src="'.$thumbnail.'" /></a></div>
						<div class="post-sample">'.$post_content.'<div class="read-full-article"><a href="?id='.$post_id.'" class="read-full-article-hover">Read full post ></a></div></div>
					</div>';
			}
			$comment_count = 0;
		}
		if($post_count == 0){
			echo '<center><div class="empty_result">Currently there are no records in our database.</div></center>"';
		}
	}
	function showArchivePosts($connection){
		$data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10, 18446744073709551615");
		$post_count = 0;

		while($row = mysqli_fetch_array($data)){
			$timestamp = strtotime($row['timestamp']);
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

			$day =  date('d', $timestamp);
			$month =  date('m', $timestamp);

			switch($month){
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

			$year =  date('Y', $timestamp);

			$comment_data = mysqli_query($connection, "SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

			while($comment_row = mysqli_fetch_array($comment_data)){
				$comment_count++;
			}

			if(empty($thumbnail)){
				$thumbnail = 'css/images/image-missing.png';
			}

			$total_ratings = 0;
			$total_score = 0;
			$datax = mysqli_query($connection, "SELECT * FROM `ratings` WHERE `post_id` = $post_id");
			while($rowx = mysqli_fetch_array($datax)){
				$rating = $rowx['rating'];
				$total_score += $rating;
				$total_ratings++;
			}

			if($total_ratings != 0){
				$average_rating = round($total_score / $total_ratings, 1);
				settype($average_rating, 'float');
			}

			if(loggedIn() && notVoted($connection, $post_id)){
				$rating = '
					<div class="stars-bg">
						<a href="vote.php?post_id='.$post_id.'&rating=1"><div class="star-1"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=2"><div class="star-2"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=3"><div class="star-3"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=4"><div class="star-4"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=5"><div class="star-5"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=6"><div class="holder"></div></a>
					</div>
				';
			}else{
				if($total_score <= 0){
					$rating = '<img src="css/images/rating-0-stars.png" title="'.$total_score.'/5" />';
				}elseif($average_rating <= 1){
					$rating = '<img src="css/images/rating-1-star.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 2){
					$rating = '<img src="css/images/rating-2-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 3){
					$rating = '<img src="css/images/rating-3-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 4){
					$rating = '<img src="css/images/rating-4-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 5){
					$rating = '<img src="css/images/rating-5-stars.png" title="'.$average_rating.'/5" />';
				}
			}

			if($public == 1){
				$post_content = preg_replace('/\s+?(\S+)?$/', '', substr($post_content, 0, 255));
				echo '
					<div class="post">
						<div class="post-title"><a href="?id='.$post_id.'">'.strtoupper($post_title).'</a></div>
						<div class="post-social">
							<table>
								<tr>
									<td>
										<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									</td>
									<td>
										<a href="#"
										  onclick="
											window.open(
											  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
											  \'facebook-share-dialog\', 
											  \'width=626,height=436\'); 
											return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
									</td>
									<td>
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://miloszdura.com/techblog/?id='.$post_id.'" data-text="'.strtoupper($post_title).'" data-via="GamingPassionPL">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
									</td>
									<td>
										<div class="g-plusone" data-size="medium" data-href="http://miloszdura.com/techblog/?id='.$post_id.'"></div>
										<script type="text/javascript">
										  window.___gcfg = {lang: \'en-GB\'};
										
										  (function() {
											var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
											po.src = \'https://apis.google.com/js/plusone.js\';
											var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>				
										</div>
									</td>
									<td>
										<table>
											<tr>
												<td>Rating:</td><td>'.$rating.'</td><td>('.$total_ratings.')</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="post-info"><a href="profile.php?user='.$post_author.'">'.$post_author.'</a> at '.$time.' on '.$day.' '.$month.' '.$year.'</div>
						<div class="post-image"><a href="?id='.$post_id.'"><img src="'.$thumbnail.'" /></a></div>
						<div class="post-sample">'.$post_content.'<div class="read-full-article"><a href="?id='.$post_id.'" class="read-full-article-hover">Read full post ></a></div></div>
					</div>';
			}
			$comment_count = 0;
		}
		if($post_count == 0){
			echo '<center><div class="empty_result">Currently there are no records in our database.</div></center>';
		}
	}
	function showOnePost($id){
		$post_id = $id;

		$data2 = mysqli_query($this->database->connection, "SELECT * FROM `posts` ORDER BY post_id DESC LIMIT 1");

		while($row2 = mysqli_fetch_array($data2)){
			$top_post_id = $row2['post_id'];
		}

		if($post_id > $top_post_id || $post_id < 0){
			echo '<center><h1>Post not found.</h1><br /><p><a href="index.php">HOME</a></p></center>';
		}

		$data = mysqli_query($this->database->connection, "SELECT * FROM `posts` WHERE section = 'pl' AND `post_id` = $post_id ORDER BY `post_id` DESC LIMIT 1");
		$comment_count = 0;

		while($row = mysqli_fetch_array($data)){
			$timestamp = strtotime($row['timestamp']);
			$date =  date('d.m.Y', $timestamp);
			$time = date('G:i', $timestamp);
			$public = $row['public'];
			$thumbnail = $row['thumbnail'];
			$post_content = $row['post_content'];
			$post_title = $row['post_title'];
			$post_author = $row['post_author'];
			$category = $row['post_category'];

			$day =  date('d', $timestamp);
			$month =  date('m', $timestamp);

			switch($month){
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

			$total_ratings = 0;
			$total_score = 0;
			$datax = mysqli_query($this->database->connection, "SELECT * FROM `ratings` WHERE `post_id` = $post_id");
			while($rowx = mysqli_fetch_array($datax)){
				$rating = $rowx['rating'];
				$total_score += $rating;
				$total_ratings++;
			}

			if($total_ratings != 0){
				$average_rating = round($total_score / $total_ratings, 1);
				settype($average_rating, 'float');
			}

			if(loggedIn() && notVoted($this->database->connection, $post_id)){
				$rating = '
					<div class="stars-bg">
						<a href="vote.php?post_id='.$post_id.'&rating=1"><div class="star-1"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=2"><div class="star-2"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=3"><div class="star-3"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=4"><div class="star-4"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=5"><div class="star-5"></div></a>
						<a href="vote.php?post_id='.$post_id.'&rating=6"><div class="holder"></div></a>
					</div>
				';
			}else{
				if($total_score <= 0){
					$rating = '<img src="css/images/rating-0-stars.png" title="'.$total_score.'/5" />';
				}elseif($average_rating <= 1){
					$rating = '<img src="css/images/rating-1-star.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 2){
					$rating = '<img src="css/images/rating-2-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 3){
					$rating = '<img src="css/images/rating-3-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 4){
					$rating = '<img src="css/images/rating-4-stars.png" title="'.$average_rating.'/5" />';
				}elseif($average_rating <= 5){
					$rating = '<img src="css/images/rating-5-stars.png" title="'.$average_rating.'/5" />';
				}
			}

			$year =  date('Y', $timestamp);

			$hours_ago = intval((time() - $timestamp) / 3600);
			$days_ago = intval((time() - $timestamp) / 86400);
			$years_ago = intval(((time() - $timestamp) / 86400) / 365);

			$comment_data = mysqli_query($this->database->connection, "SELECT * FROM `comments` WHERE comment_post_id = $post_id AND active = 1");

			while($comment_row = mysqli_fetch_array($comment_data)){
				$comment_count++;
			}

			if(empty($thumbnail)){
				$thumbnail = 'css/images/image-missing.png';
			}

			if(isset($_SESSION['username'])) {
				$user = $_SESSION['username'];
				$data = mysqli_query($this->database->connection, "SELECT * FROM `comments` WHERE `comment_author` = '$user' ORDER BY timestamp DESC LIMIT 1");

				while ($row = mysqli_fetch_array($data)) {
					$last_comment_time = $row['timestamp'];
				}

				$last_comment_time = strtotime($last_comment_time);
				$today = time();

				$time_difference = $today - $last_comment_time;

				$time_difference = 300 - $time_difference;

				$minutes = intval(date('i', $time_difference));
				$seconds = intval(date('s', $time_difference));
			}
			if($public == 1 || adminUser()){
					if(isset($_GET['success'])){
						echo '<div class="green-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>Your comment has been successfully posted.</td></tr></table></div>';
					}
					if(isset($_GET['fields-not-set'])){
						echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>All fields are required.</td></tr></table></div>';
					}
					if(isset($_GET['bot-alert'])){
						echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>Recaptcha is wrong.</td></tr></table></div>';
					}
					if(isset($_GET['time'])){
						echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>Not too fast! You can comment again in <strong>'.$minutes.'</strong> minutes and <strong>'.$seconds.'</strong> seconds.</td></tr></table></div>';
					}

					if($category == 'news'){
						$category_en = 'news';
					}elseif($category == 'recenzja'){
						$category_en = 'reviews';
					}elseif($category == 'gameplay'){
						$category_en = 'gameplay';
					}
					if($public == 0 && adminUser()){
						echo '<div class="red-message"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>Ten post nie jest publiczny.</td></tr></table></div>';
					}

			echo '
				<p>
					<strong>You are here:</strong> <a href="\techblog">HOME</a> > <a href="'.$category_en.'.php">'.strtoupper($category).'</a> > <a href="?id='.$post_id.'">'.strtoupper($post_title).'</a>
				</p>
				<div class="holder"></div>
					<div class="post" style="margin-top:15px;">
						<div class="post-title"><a href="?id='.$post_id.'">'.strtoupper($post_title).'</a></div>
						<div class="post-social">
							<table>
								<tr>
									<td>
										<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									</td>
									<td>
										<a href="#"
										  onclick="
											window.open(
											  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), 
											  \'facebook-share-dialog\', 
											  \'width=626,height=436\'); 
											return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Udostepnij na Facebooku" /></a>
									</td>
									<td>
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://miloszdura.com/techblog/?id='.$post_id.'" data-text="'.strtoupper($post_title).'" data-via="GamingPassionPL">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
									</td>
									<td>
										<div class="g-plusone" data-size="medium" data-href="http://miloszdura.com/techblog/?id='.$post_id.'"></div>
										<script type="text/javascript">
										  window.___gcfg = {lang: \'en-GB\'};
										
										  (function() {
											var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
											po.src = \'https://apis.google.com/js/plusone.js\';
											var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>				
										</div>
									</td>
									<td>
										<table>
											<tr>
												<td>Rating:</td><td>'.$rating.'</td><td>('.$total_ratings.')</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="post-info"><a href="profile.php?user='.$post_author.'">'.$post_author.'</a> at '.$time.' on '.$day.' '.$month.' '.$year.'</div>
						<div class="post-image"><a href="?id='.$post_id.'"><img src="'.$thumbnail.'" /></a></div>
						<div class="post-sample">'.$post_content.'</div>
					</div>
				<h2 style="border-bottom:2px solid #ccc; padding-bottom:3px;">Tags</h2>
				';
					$tags_data = mysqli_query($this->database->connection, "SELECT * FROM `posts` WHERE post_id = $post_id");
					while($tags_row = mysqli_fetch_array($tags_data)){
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
					<h2 style="border-bottom:2px solid #ccc;">Facebook Comments</h2><br />
					<center>
					<div class="fb-comments" data-href="http://www.gaming-passion.com/?id='.$post_id.'" data-width="670" data-numposts="10" data-colorscheme="light"></div>
					</center>
					<h2 style="border-bottom:2px solid #ccc;">Comments</h2>
					'; ?>
				<?php
					$post_id = $_GET['id'];
					$comment_data = mysqli_query($this->database->connection, "SELECT * FROM `comments` WHERE `comment_post_id` = '$post_id' AND `active` = 1 ORDER BY timestamp DESC");
					$comment_count = 0;
					while($comment_row = mysqli_fetch_array($comment_data)){
						$timestamp = strtotime($comment_row['timestamp']);
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
							<i><strong><a href="profile.php?user='.$comment_row['comment_author'].'" class="comment-author-link" style="color:'.$color.';">'.$comment_row['comment_author'].'</a></strong></strong> at <strong>'.$time.'</strong> on <strong>'.$date.'</strong> ('.$hours_ago.')</strong></i><br /><br />
							<span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">"'.$comment_row['comment_content'].'"</span>
						</div>
						';
					}
					if($comment_count == 0 ){
						echo '<center><div class="empty_result">Currently there are no comments for this article.</div></center>';
					}

					if(loggedIn() == true){
					   if(adminUser() == true){
							echo '<br />
						<h2 style="border-bottom:2px solid #ccc;">Add Comment</h2>
						<div class="form-table">
							<center>
								<form action="comment-check.php" method="post">
									<table>
										<tr>
											<td>Comment:</td><td><textarea name="comment-content" style="width:400px; height:100px;"></textarea></td>
										</tr>
										<tr>
											<td></td>
											<td>
												<div class="g-recaptcha" data-sitekey="6LeXsf4SAAAAAF8YxjHnQw3VYqZPF9BQ79QR4osg"></div>
												<input type="text" name="comment_author_status" value="admin" style="visibility:hidden; width:0px; height:0px;" />
												<input type="text" name="post_id" value="'.$_GET['id'].'" style="visibility:hidden; width:0px; height:0px;" />
											</td>
										</tr>
										<tr>
											<td></td><td><button type="submit" value="" class="button">Submit</button></td>
										</tr>
									</table>
								</form>
							</center>
						</div>
							';
						}elseif(modUser() == true){
							echo '<br />
						<h2 style="border-bottom:2px solid #ccc;">Add Comment</h2>
						<div class="form-table">
							<center>
								<form action="comment-check.php" method="post">
									<table>
										<tr>
											<td>Comment:</td><td><textarea name="comment-content" style="width:400px; height:100px;"></textarea></td>
										</tr>
										<tr>
											<td></td>
											<td>
												<div class="g-recaptcha" data-sitekey="6LeXsf4SAAAAAF8YxjHnQw3VYqZPF9BQ79QR4osg"></div>
												<input type="text" name="comment_author_status" value="mod" style="visibility:hidden; width:0px; height:0px;" />
												<input type="text" name="post_id" value="'.$_GET['id'].'" style="visibility:hidden; width:0px; height:0px;" />
											</td>
										</tr>
										<tr>
											<td></td><td><button type="submit" value="" class="button">Submit</button></td>
										</tr>
									</table>
								</form>
							</center>
						</div>
							';
						}elseif(!adminUser() && !modUser()){
							echo '<br />
						<h2 style="border-bottom:2px solid #ccc;">Add Comment</h2>
						<div class="form-table">
							<center>
								<form action="comment-check.php" method="post">
									<table>
										<tr>
											<td>Comment:</td><td><textarea name="comment-content" style="width:400px; height:100px;"></textarea></td>
										</tr>
										<tr>
											<td></td>
											<td>
												<div class="g-recaptcha" data-sitekey="6LeXsf4SAAAAAF8YxjHnQw3VYqZPF9BQ79QR4osg"></div>
												<input type="text" name="comment_author_status" value="user" style="visibility:hidden; width:0px; height:0px;" />
												<input type="text" name="post_id" value="'.$_GET['id'].'" style="visibility:hidden; width:0px; height:0px;" />
											</td>
										</tr>
										<tr>
											<td></td><td><button type="submit" value="" class="button">Submit</button></td>
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
							<h2 style="border-bottom:2px solid #ccc;">Add Comment</h2><br />
							<p>
								You need to <a href="login.php"><span style="color:#0093D9;" class="underline_link">login</span></a> to comment.<br />
								Don\'t have an account? <a href="register.php"><span style="color:#0093D9;" class="underline_link">Register</span></a> for free!
							</p>
						</div>
						';
					}
			}else{
				echo '<center><div class="empty_result">This article is no longer public.</div></center>';
			}
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
}
?>