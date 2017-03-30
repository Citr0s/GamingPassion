<?php namespace GamingPassion\Factories;

use GamingPassion\Database;
use GamingPassion\Models\Post;

class PostFactory
{
    private $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getSinglePostFor($id)
    {
        $databaseResponse = $this->database->connection->query( "SELECT * FROM `posts` WHERE `public` = 1 AND `post_id` = {$id} ORDER BY `post_id` DESC LIMIT 1");

        $row = $databaseResponse->fetch_assoc();

        $post = new Post();

        $post->id = $row['post_id'];
        $post->title = $row['post_title'];
        $post->author = $row['post_author'];
        $post->content = $row['post_content'];
        $post->createdAt = strtotime($row['timestamp']);
        $post->thumbnail = $row['thumbnail'];
        $post->category = $row['post_category'];

        if($post->category == 'news'){
            $post->category = 'news';
        }elseif($post->category == 'recenzja'){
            $post->category = 'reviews';
        }elseif($post->category == 'gameplay'){
            $post->category = 'gameplay';
        }

        return $post;
    }

    public function getAllPosts()
    {
        $response = [];

        $databaseResponse = $this->database->connection->query( "SELECT * FROM `posts` WHERE `public` = 1 ORDER BY `post_id` DESC LIMIT 0, 10");

        while($row = $databaseResponse->fetch_assoc())
        {
            $post = new Post();

            $post->id = $row['post_id'];
            $post->title = $row['post_title'];
            $post->author = $row['post_author'];
            $post->content = preg_replace('/\s+?(\S+)?$/', '', substr($row['post_content'], 0, 255));
            $post->createdAt = strtotime($row['timestamp']);
            $post->thumbnail = $row['thumbnail'];
            $post->category = $row['post_category'];

            array_push($response, $post);
        }

        return $response;
    }

    public function getAllPostsFor($category)
    {
        $response = [];

        $databaseResponse = $this->database->connection->query( "SELECT * FROM `posts` WHERE `post_category` = '{$category}' AND `public` = 1 ORDER BY `post_id` DESC LIMIT 0, 10");

        while($row = $databaseResponse->fetch_assoc())
        {
            $post = new Post();

            $post->id = $row['post_id'];
            $post->title = $row['post_title'];
            $post->author = $row['post_author'];
            $post->content = preg_replace('/\s+?(\S+)?$/', '', substr($row['post_content'], 0, 255));
            $post->createdAt = strtotime($row['timestamp']);
            $post->thumbnail = $row['thumbnail'];

            array_push($response, $post);
        }

        return $response;
    }

    public function getAllArchivedPosts()
    {
        $response = [];

        $databaseResponse = $this->database->connection->query( "SELECT * FROM `posts` WHERE `public` = 1 ORDER BY `post_id` DESC LIMIT 10, 18446744073709551615");

        while($row = $databaseResponse->fetch_assoc())
        {
            $post = new Post();

            $post->id = $row['post_id'];
            $post->title = $row['post_title'];
            $post->author = $row['post_author'];
            $post->content = preg_replace('/\s+?(\S+)?$/', '', substr($row['post_content'], 0, 255));
            $post->createdAt = strtotime($row['timestamp']);
            $post->thumbnail = $row['thumbnail'];

            array_push($response, $post);
        }

        return $response;
    }
}