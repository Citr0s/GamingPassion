	            <div id="sidebar">
				<?php
	                $data = mysqli_query($connection, "SELECT * FROM `posts` WHERE `section` = 'pl' AND public = 1 ORDER BY `post_id` DESC LIMIT 10, 10");
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
	                        $thumbnail = '/assets/images/image-missing.png';
	                    }
	            
	                    if($public == 1){
	                        echo '
	                            <div class="post-small">
	                                <a href="/?id='.$post_id.'">
	                                    <h3 style="font:14px Arial; color:#333; padding:15px 0px; text-align:right; font-weight:bold;">'.strtoupper($post_title).'</h3>
	                                </a>
	                                <a href="/?id='.$post_id.'">
	                                    <img src="'.$thumbnail.'" width="100%" />
	                                </a>
	                                <p style="color:#777; text-align:right; padding-bottom:15px;">
	                                    '.substr($post_content, 0, 152).'...
	                                    <div class="float-right">
	                                        <a href="/?id='.$post_id.'" style="font-weight:bold;">
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
	                }
	            ?>
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FGamingPassionPL&amp;width=276&amp;height=185&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false" scrolling="no" frameborder="0" style="border:1px solid #ccc; overflow:hidden; width:276px; height:185px;" allowTransparency="true"></iframe><br /><br />
	                <a class="twitter-timeline" href="https://twitter.com/GamingPassionPL" data-widget-id="348161875491569664">Tweets by @GamingPassionPL</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script><br /><br />
	            </div>
	            <div class="holder"></div>