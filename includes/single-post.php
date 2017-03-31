<?php
$post = $postService->getSinglePost($_GET['id']);

if(sizeof($post) === 0)
{
echo '<div class="empty_result">Currently there are no records in our database.</div>';
}

$ratingsResponse = $ratingService->getAllFor($post->id);

if(isset($_SESSION['username'])) {
$user = $_SESSION['username'];
$data = mysqli_query($connection, "SELECT * FROM `comments` WHERE `comment_author` = '$user' ORDER BY timestamp DESC LIMIT 1");

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
?>
<p>
    <strong>You are here:</strong> <a href="/">HOME</a> > <a href="<?php echo $post->category; ?>.php"><?php echo strtoupper($post->category); ?></a> > <a href="?id=<?php echo $post->id; ?>"><?php echo strtoupper($post->title); ?></a>
</p>
<div class="holder"></div>
<div class="post" style="margin-top:15px;">
    <div class="post-title"><a href="?id=<?php echo $post->id; ?>"><?php echo strtoupper($post->title); ?></a></div>
    <div class="post-social">
        <table>
            <tr>
                <td>
                    <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
                </td>
                <td>
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;"><img src="css/images/share-button.png" style="border:none; height:20px;" title="Share on Facebook" /></a>
                </td>
                <td>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $post->title; ?>" data-via="GamingPassionPL">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </td>
                <td>
                    <div class="g-plusone" data-size="medium" data-href="https://techblog.miloszdura.com/?id=<?php echo $post->id; ?>"></div>
                    <script type="text/javascript">
                        window.___gcfg = {lang: 'en-GB'};

                        (function() {
                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                            po.src = 'https://apis.google.com/js/plusone.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                        })();
                    </script>
    </div>
    </td>
    <td>
        <table>
            <tr>
                <td>Rating:</td>
                <td>
                    <?php
                    if(loggedIn() && notVoted($connection, $post->id))
                    {
                        ?>
                        <div class="stars-bg">
                            <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=1"><div class="star-1"></div></a>
                            <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=2"><div class="star-2"></div></a>
                            <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=3"><div class="star-3"></div></a>
                            <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=4"><div class="star-4"></div></a>
                            <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=5"><div class="star-5"></div></a>
                            <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=6"><div class="holder"></div></a>
                        </div>
                        <?php
                    }
                    else
                    {
                        $ratingAverage = $ratingsResponse->average === null ? 0 : $ratingsResponse->average;
                        ?>
                        <img src="css/images/rating-<?php echo $ratingAverage; ?>-stars.png" title="<?php echo $ratingAverage; ?>/5" />
                        <?php
                    }
                    ?>
                </td>
                <td>(<?php echo sizeof($ratingsResponse->ratings); ?>)</td>
            </tr>
        </table>
    </td>
    </tr>
    </table>
</div>
<div class="post-info"><a href="profile.php?user=<?php echo $post->author; ?>"><?php echo $post->author; ?></a> at <?php echo date('H:i \o\n d F Y', $post->createdAt); ?></div>
<div class="post-image"><a href="?id=<?php echo $post->id; ?>"><img src="<?php echo $post->thumbnail; ?>" /></a></div>
<div class="post-sample"><?php echo $post->content; ?></div>
</div>
<h2 style="border-bottom:2px solid #ccc; padding-bottom:3px;">Tags</h2>
<?php
$tags_data = mysqli_query($connection, "SELECT * FROM `posts` WHERE post_id = $post->id");
while($tags_row = mysqli_fetch_array($tags_data)){
    $tags = explode(", ", $tags_row['tags']);
    $a = count($tags);
    $b = 0;
    for($i = 0; $i < $a; $i++){
        echo '<span class="tag">'.strtolower($tags[$b]).'</span>';
        $b++;
    }
}
?>
<div class="holder"></div>
<br />
<h2 style="border-bottom:2px solid #ccc;">Facebook Comments</h2><br />
<center>
    <div class="fb-comments" data-href="http://www.gaming-passion.com/?id='.$post_id.'" data-width="670" data-numposts="10" data-colorscheme="light"></div>
</center>
<h2 style="border-bottom:2px solid #ccc;">Comments</h2>
<?php

$comments = $commentService->getAllFor($post->id);

foreach($comments as $comment){

    if($comment->authorStatus == 'admin'){
        $color = '#FF0000';
    }elseif($comment->authorStatus == 'mod'){
        $color = '#0000FF';
    }elseif($comment->authorStatus == 'user'){
        $color = '#333';
    }else{
        $color = '#333';
    }

    $date =  date('d.m.Y', $comment->createdAt);
    $time = date('G:i', $comment->createdAt);
    $hours_ago = intval((time() - $comment->createdAt) / 3600);
    $days_ago = intval((time() - $comment->createdAt) / 86400);
    $years_ago = intval(((time() - $comment->createdAt) / 86400) / 365);

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

    ?>
    <div class="post-comment">
        <i><strong><a href="profile.php?user=<?php echo $comment->author; ?>" class="comment-author-link" style="color:<?php echo $color; ?>"><?php echo $comment->author; ?></a></strong></strong> at <strong><?php echo $time; ?></strong> on <strong><?php echo $date; ?></strong> (<?php echo $hours_ago; ?>)</strong></i><br /><br />
        <span style="font:13px Arial; font-style:italic; color:#777; font-size:14px;">"<?php echo $comment->content; ?>"</span>
    </div>
    <?php
}

if(loggedIn() == true){
    if(adminUser($connection) == true){
        ?>
        <br />
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
        <?php
    }elseif(modUser() == true){
        ?>
        <br />
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
        <?php
    }elseif(!adminUser() && !modUser()){
        ?>
        <br />
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
        <?php
    }
}else{
    ?>
    <div class="not-logged-in-comment"><br />
        <h2 style="border-bottom:2px solid #ccc;">Add Comment</h2><br />
        <p>
            You need to <a href="login.php"><span style="color:#0093D9;" class="underline_link">login</span></a> to comment.<br />
            Don\'t have an account? <a href="register.php"><span style="color:#0093D9;" class="underline_link">Register</span></a> for free!
        </p>
    </div>
    <?php
}

?>