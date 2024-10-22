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
                if (isset($_GET['id'])) {
                    include_once 'includes/single-post.php';
                } else {
                    $posts = $postService->getAll();
                    if (sizeof($posts) === 0) {
                        echo '<div class="empty_result">Currently there are no records in our database.</div>';
                    }
                    foreach ($posts as $post) {
                        $ratingsResponse = $ratingService->getAllFor($post->id);
                        ?>
                        <div class="post">
                            <div class="post-title"><a href="?id=<?php echo $post->id; ?>"><?php echo strtoupper($post->title); ?></a></div>
                            <div class="post-social">
                                <table>
                                    <tr>
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
                            <div class="post-sample">
                                <pre><?php echo htmlspecialchars($post->content); ?>...</pre>
                                <div class="read-full-article">
                                    <a href="?id=<?php echo $post->id; ?>" class="read-full-article-hover">Read full post ></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php include_once 'includes/sidebar.php'; ?>
        </div>
    </div>
<?php
include_once 'includes/footer.php';