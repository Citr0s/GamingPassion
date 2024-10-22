<?php
    include_once '../core/bootstrap.php';
    require_once 'counters.php';

    if(!loggedIn() || !adminUser($connection)){
        if(!modUser($connection)){
            header("Location: /techblog/index.php");
        }
    }

    include_once 'sidebar.php';

?>
        <script>
            document.getElementById('new-articles-button').style.color = "#fff";
            document.getElementById('new-articles-button').style.borderLeft = "1px solid #007be9";
        </script>
        <div id="main-content">
            <div class="h1">
                <table>
                    <tr>
                        <td>
                            <i class="fa fa-pencil" style="font-size:60px; margin-right:10px;"></i>
                        </td>
                        <td>
                            NEW ARTICLE
                            <div style="font-size:13px;"><a href="/techblog/dashboard"><span style="color:#666;">HOME</span></a> / <span style="color:#777;">NEW ARTICLE</span></div>
                        </td>
                    </tr>
                </table>
                    <div id="postContaiener" style="margin-top:15px;">
                        <form action="check_post.php" method="post" enctype="multipart/form-data">
                            <div class="fancy-table">
                                <table>
                                    <tr>
                                        <td valign="middle">Title:<span class="green-text">*</span></td><td><input type="text" name="post_title"/></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Post:<span class="green-text">*</span></td><td><textarea name="post_content"/></textarea></td>
                                    <tr>
                                        <td valign="middle">Kategoria:<span class="green-text">*</span></td><td><select name="post_category"><option value="news">News</option><option value="recenzja">Recenzja</option><option value="poradnik">Poradnik</option><option value="gameplay">Gameplay</option></select></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Autor:<span class="green-text">*</span></td><td><input type="text" name="post_author" value="<?php echo $_SESSION['username']; ?>" disabled="disabled" /></td><td><div style="visibility:hidden; width:1px;"><input type="text" name="post_author" value="<?php echo $_SESSION['username']; ?>" disabled="disabled" /></div></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle"title="Wybierz obrazek.">Obrazek:</td><td><input type="file" name="filename" /></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">*Tagi:</td><td><input type="text" name="tags" /></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="post-fields"></td><td><center><button type="submit" class="button">Send</button></center></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="fancy-table">
                                <i>All fields are required<span class="green-text">*</span>.</i><br /><hr /><br />
                                <i>Info about uploading:<span class="green-text">*</span></i><br /><hr /><br />
                                Thumbnail:<br />Max 500kb<br />650x363<br />jpg/png/gif<br /><br />
                                <i>Seperate tags with commas.<span class="green-text">*</span></i><br /><hr /><br />
                                (tag1, tag2, tag3)<br /><br />
                                <i>Available Tags:<span class="green-text">*</span></i><br /><hr /><br />
                                <strong>Code:</strong> <?php echo htmlentities('<div class="code"><code>Content</code></div>'); ?><br />
                                <strong>Quote:</strong> <?php echo htmlentities('<div class="quote"></div>'); ?><br />
                                <strong>Image:</strong> <?php echo htmlentities('<img src="link-to-the-image" />'); ?><br />
                                <strong>Link:</strong> <?php echo htmlentities('<a href="link">Text or Image</a>'); ?><br />
                                <strong>Unordered List:</strong> <?php echo htmlentities('<ul><li>Item</li></ul>'); ?><br />
                                <strong>Ordered List:</strong> <?php echo htmlentities('<ol><li>Item</li></ol>'); ?><br />
                            </div>
                            <div class="holder"></div>
                        </form>
                    </div>
            </div>
        </div>
        <div class="holder"></div>
    </div>
</body>
</html>