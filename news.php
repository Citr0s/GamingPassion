<?php
include_once 'core/bootstrap.php';
include_once 'includes/header.php';
?>
<div id="container">
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>You have been successfully <strong>logged in</strong>.</td></tr></table></div>';
    }
    ?>
    <?php
    if (isset($_GET['logout'])) {
        echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>You have been successfully <strong>logged out</strong>.</td></tr></table></div>';
    }
    ?>
    <div id="slideshow">
        <?php include_once 'includes/slideshow.php'; ?>
    </div>
    <div id="index-landing">
        <div id="main-content">
            <?php
            if (isset($_GET['id'])){
                $postService->showOnePost($_GET['id']);
            }else{
            if (isset($_GET['id']))
            {
                include_once 'includes/single-post.php';
            }
            else
            {
            $posts = $postService->getAllFor('news');

            if (sizeof($posts) === 0) {
                echo '<div class="empty_result">Currently there are no records in our database.</div>';
            }

            foreach ($posts

            as $post)
            {

            $ratingsResponse = $ratingService->getAllFor($post->id);
            ?>
            <div class="post">
                <div class="post-title"><a href="?id=<?php echo $post->id; ?>"><?php echo strtoupper($post->title); ?></a></div>
                <div class="post-social">
                    <table>
                        <tr>
                            <td>
                                <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmiloszdura.com%2Ftechblog%2F%3Fid%3D'.$post_id.'&amp;width=50&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21"
                                        scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
                            </td>
                            <td>
                                <a href="#"
                                   onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;"><img
                                            src="css/images/share-button.png" style="border:none; height:20px;" title="Share on Facebook"/></a>
                            </td>
                            <td>
                                <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $post->title; ?>" data-via="GamingPassionPL">Tweet</a>
                                <script>!function (d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                        if (!d.getElementById(id)) {
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = p + '://platform.twitter.com/widgets.js';
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }
                                    }(document, 'script', 'twitter-wjs');</script>
                            </td>
                            <td>
                                <div class="g-plusone" data-size="medium" data-href="https://techblog.miloszdura.com/?id=<?php echo $post->id; ?>"></div>
                                <script type="text/javascript">
                                    window.___gcfg = { lang: 'en-GB' };

                                    (function () {
                                        var po = document.createElement('script');
                                        po.type = 'text/javascript';
                                        po.async = true;
                                        po.src = 'https://apis.google.com/js/plusone.js';
                                        var s = document.getElementsByTagName('script')[0];
                                        s.parentNode.insertBefore(po, s);
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
                                if (loggedIn() && notVoted($connection, $post->id)) {
                                    ?>
                                    <div class="stars-bg">
                                        <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=1">
                                            <div class="star-1"></div>
                                        </a>
                                        <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=2">
                                            <div class="star-2"></div>
                                        </a>
                                        <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=3">
                                            <div class="star-3"></div>
                                        </a>
                                        <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=4">
                                            <div class="star-4"></div>
                                        </a>
                                        <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=5">
                                            <div class="star-5"></div>
                                        </a>
                                        <a href="vote.php?post_id=<?php echo $post->id; ?>&rating=6">
                                            <div class="holder"></div>
                                        </a>
                                    </div>
                                    <?php
                                } else {
                                    $ratingAverage = $ratingsResponse->average === null ? 0 : $ratingsResponse->average;
                                    ?>
                                    <img src="css/images/rating-<?php echo $ratingAverage; ?>-stars.png" title="<?php echo $ratingAverage; ?>/5"/>
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
            <div class="post-image"><a href="?id=<?php echo $post->id; ?>"><img src="<?php echo $post->thumbnail; ?>"/></a></div>
            <div class="post-sample"><?php echo $post->content; ?>
                <div class="read-full-article"><a href="?id=<?php echo $post->id; ?>" class="read-full-article-hover">Read full post ></a></div>
            </div>
        </div>
        <?php
        }
        }
        }
        ?>
    </div>
    <?php include_once 'includes/sidebar.php'; ?>
</div>
</div>
<?php
include_once 'includes/footer.php';
?>
