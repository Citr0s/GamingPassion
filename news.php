<?php
	include_once 'core/bootstrap.php';
	include_once 'includes/header.php';
?>
		<div id="container">
			<?php
				if(isset($_GET['success'])){
					echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>You have been successfully <strong>logged in</strong>.</td></tr></table></div>';
				}
			?>
			<?php
				if(isset($_GET['logout'])){
					echo '<div class="green-message" style="margin-bottom:15px;"><table><tr><td style="padding-right:5px;"><img src="assets/images/popup-info-icon.png" /></td><td>You have been successfully <strong>logged out</strong>.</td></tr></table></div>';
				}
			?>
			<div id="slideshow">
				<?php include_once 'includes/slideshow.php'; ?>
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
                    <post-list category="news"></post-list>
                <?php
                    }
                ?>
                </div>
                <?php include_once 'includes/sidebar.php'; ?>
            </div>
		</div>
<?php
	include_once 'includes/footer.php';
?>