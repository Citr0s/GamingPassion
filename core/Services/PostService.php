<?php namespace GamingPassion\Services;

use GamingPassion\Factories\PostFactory;

class PostService
{
    private $postFactory;

    function __construct(PostFactory $postFactory)
    {
        $this->postFactory = $postFactory;
    }

	public function getAll(){
        return  $this->postFactory->getAllPosts();
	}

    public function getAllFor($category)
    {
        return  $this->postFactory->getAllPostsFor($category);
    }

    public function getArchived()
    {
        return  $this->postFactory->getAllArchivedPosts();
    }
    
	function getSinglePost($id){
		return $this->postFactory->getSinglePostFor($id);
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
            $thumbnail = 'assets/images/image-missing.jpg';
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