<!DOCTYPE html>
<html lang="en" ng-app="gamingPassion">
<head>
    <meta charset="UTF-8">
    <title>Gaming Passion | News, Reviews, Fun</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <link rel="icon" href="css/images/favicon.ico" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-50985585-2', 'auto');
        ga('send', 'pageview');

    </script>
    <script src="../js/app.js"></script>
    <script src="../js/factories/RetrievePostsService.js"></script>
    <script src="../js/factories/RetrieveRatingsService.js"></script>
    <script src="../js/directives/PostList.js"></script>
</head>
<body ng-controller="PostController">
<div id="wrapper">
    <div id="header">
        <div class="container">
            <div class="float-left">
                <div style="width:0px;">
                    <a href="/"><img src="css/images/logo-main.jpg" alt="gaming passion logo" /></a>
                </div>
            </div>
            <div class="float-right">
                <div id="login-area">
                    <span class="greeting">Welcome to our website!</span>
                    <span class="login-options">
						<?php
                        if(isset($_SESSION['username'])){
                            echo '
									<ul>
										<li><a href="profile.php?user='.$user->username.'">My Account ('.$user->username.')</a></li>
										<li><a href="badges.php">Badges</a></li>
										<li><a href="logout.php">Logout</a></li>
										<li><a href="messages.php">Private Messages</a></li>';

                            if(adminUser($connection) || moduser($connection)){
                                echo '
												<li><a href="/dashboard">Dashbaord</a></li>
											';
                            }

                            echo '
									</ul>
								';
                        }else{
                            echo '
									<ul>
										<li><a hrefg="login.php">My Account</a></li>
										<li><a href="login.php">Badges</a></li>
										<li><a href="login.php">Login</a></li>
										<li><a href="register.php">Register</a></li>
									</ul>
								';
                        }
                        ?>
						</span>
                    <span class="search">
							<form>
								<input type="text" name="search" class="search-box" placeholder="Search" />
								<button type="submit" class="button" style="margin-bottom:2px;"><i class="fa fa-search"></i></button>
							</form>
						</span>
                </div>
            </div>
            <div class="holder"></div>
        </div>
    </div>
    <div id="menu">
        <div class="container">
            <ul>
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="news.php"><i class="fa fa-bolt"></i> News</a></li>
                <li><a href="reviews.php"><i class="fa fa-bar-chart-o"></i> Reviews</a></li>
                <li><a href="archive.php"><i class="fa fa-archive"></i> Archive</a></li>
                <li><a href=""><i class="fa fa-comments-o"></i> Forum</a></li>
            </ul>
        </div>
    </div>

    <div id="container">
        <?php
        if(isset($_GET['success'])){
            echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>You have been successfully <strong>logged in</strong>.</td></tr></table></div>';
        }
        ?>
        <?php
        if(isset($_GET['logout'])){
            echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="css/images/popup-info-icon.png" /></td><td>You have been successfully <strong>logged out</strong>.</td></tr></table></div>';
        }
        ?>
        <div id="slideshow">
            <div>
                <div class="note">
                    <h2>Game of Codes</h2>
                    <h3>YouTube</h3>
                    <p>This amazing YouTube video comes from the annual JavaZone software development conference. The event is held in Oslo, Norway and is mainly focused on knowledge exchange...</p>
                    <a href="/?id=3"><div class="button">Read Full Article</div></a>
                </div>
                <img src="css/slideshow/slider_pic3.jpg" />
            </div>
        </div>
        <div id="index-landing">
            <div id="main-content">
                <?php
                if(isset($_GET['id']))
                {
                    include_once 'includes/single-post.php';
                }
                else
                {
                    ?>
                    <post-list></post-list>
                    <?php
                }
                ?>
            </div>
            <div id="sidebar">
                <?php

                /*$data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10, 10");
                $post_count = 0;

                while($row = mysqli_fetch_array($data)){

                    $timestamp = strtotime($row['timestamp']);
                    $date =  date('d/m/Y', $timestamp);
                    $time = date('G:i', $timestamp);
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = htmlentities($row['post_content'], ENT_QUOTES, 'UTF-8');
                    $post_count++;
                    $public = $row['public'];
                    $thumbnail = $row['thumbnail'];

                    if(empty($thumbnail)){
                        $thumbnail = '../css/images/image-missing.png';
                    }

                    if($public == 1){
                        echo '
	                            <div class="post-small">
	                                <a href="/article/?id='.$post_id.'">
	                                    <h3 style="font:14px Arial; color:#333; padding:15px 0px; text-align:right; font-weight:bold;">'.strtoupper($post_title).'</h3>
	                                </a>
	                                <a href="/article/?id='.$post_id.'">
	                                    <img src="'.$thumbnail.'" width="100%" />
	                                </a>
	                                <p style="color:#777; text-align:right; padding-bottom:15px;">
	                                    '.substr($post_content, 0, 152).'...
	                                    <div class="float-right">
	                                        <a href="/article/?id='.$post_id.'" style="font-weight:bold;">
	                                            <h6 style="font:10px Arial; margin-bottom:15px;">(czytaj dalej / skomentuj)</h6>
	                                        </a>
	                                    </div>
	                                    <div class="holder"></div>
	                                </p>
	                            </div>';
                    }
                }
                if($post_count == 0){
                    echo '<center><div class="empty_result">Currently there are no records in our database.</div></center>';
                }*/
                ?>
                <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FGamingPassionPL&amp;width=276&amp;height=185&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false" scrolling="no" frameborder="0" style="border:1px solid #ccc; overflow:hidden; width:276px; height:185px;" allowTransparency="true"></iframe><br /><br />
                <a class="twitter-timeline" href="https://twitter.com/GamingPassionPL" data-widget-id="348161875491569664">Tweets by @GamingPassionPL</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script><br /><br />
            </div>
            <div class="holder"></div>
        </div>
    </div>

    <div id="footer">
        <div class="footer-container">
            <table style="margin-bottom:20px;">
                <tr>
                    <td>
                        <ul>
                            <li>
                                <div class="footer-heading">Information</div>
                            </li>
                            <li>
                                <a href="">About us</a>
                            </li>
                            <li>
                                <a href="">Customer Service</a>
                            </li>
                            <li>
                                <a href="">Template Settings</a>
                            </li>
                            <li>
                                <a href="">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="">Site Map</a>
                            </li>
                            <li>
                                <a href="">Search Terms</a>
                            </li>
                            <li>
                                <a href="">Advanced Search</a>
                            </li>
                            <li>
                                <a href="">Orders and Returns</a>
                            </li>
                            <li>
                                <a href="">Contact Us</a>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <?php
                        if(isset($_SESSION['username'])){
                            echo '
									<ul>
										<li>
											<div class="footer-heading">My account</div>
										</li>
										<li>
											<a href="profile.php?user='.$_SESSION['username'].'">My Profile</a>
										</li>
										<li>
											<a href="messages.php">Private Messages</a>
										</li>
										<li>
											<a href="badges.php">Badges</a>
										</li>
										<li>
											<a href="logout.php">Logout</a>
										</li>
									</ul>
								';
                        }else{
                            echo '
									<ul>
										<li>
											<div class="footer-heading">My account</div>
										</li>
										<li>
											<a href="login.php">Login</a>
										</li>
										<li>
											<a href="register.php">Register</a>
										</li>
										<li>
											<a href="login.php">Private Messages</a>
										</li>
										<li>
											<a href="login.php">Badges</a>
										</li>
									</ul>
								';
                        }
                        ?>
                    </td>
                    <td>
                        <ul>
                            <li>
                                <div class="footer-heading" style="width:70px;">Follow us!</div>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/GamingPassionPL">Facebook</a>
                            </li>
                            <li>
                                <a href="https://twitter.com/GamingPassionPL">Twitter</a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/user/GamingPassionPL/">YouTube</a>
                            </li>
                            <li>
                                <a href="mailto:gamingpassionpl@gmail.com">Email</a>
                            </li>
                        </ul>
                    </td>
                    <td style="padding-right:0px; padding-left:190px;">
                        <img src="css/images/logo-main.jpg" alt="gaming passion logo" />
                    </td>
                </tr>
            </table>
            <div style="font-size:11px; margin-bottom:20px;">&copy; 2013 - 2014 <a href="http://www.gaming-passion.com/">Gaming Passion.</a> All Rights Reserved.<br />Designed and Developed by <a href="http://www.miloszdura.com/">Milosz Dura</a></div>
        </div>
    </div>
</div>
</body>
</html>