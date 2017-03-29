<?php namespace GamingPassion;

use GamingPassion\Models\GetAllRatingsResponse;
use GamingPassion\Models\Rating;
use GamingPassion\Models\User;
use GamingPassion\Models\Post;
use GamingPassion\Models\ValidationResponse;

class Database
{
    public $connection;

    function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getUserByUsername($username)
    {
        $validationResponse = $this->validateUsername($username);

        if($validationResponse->hasError)
            return $validationResponse->error->message;

        $databaseResponse = $this->connection->query( "SELECT * FROM `users` WHERE username = '{$validationResponse->validatedField}' LIMIT 1");
        $row = $databaseResponse->fetch_assoc();

        $response = new User();

        $response->username = $row['username'];
        $response->email = $row['email'];
        $response->gender = $row['gender'];
        $response->home = $row['home'];
        $response->active = $row['active'];
        $response->joined = $row['joined'];
        $response->thumbnail = $row['thumbnail'];
        $response->status = $row['status'];

        return $response;
    }

    public function getAllPosts()
    {
        $response = [];

        $databaseResponse = $this->connection->query( "SELECT * FROM `posts` WHERE public = 1 ORDER BY `post_id` DESC LIMIT 0, 10");

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

    public function getAllPostsFor($category)
    {
        $response = [];

        $databaseResponse = $this->connection->query( "SELECT * FROM `posts` WHERE `post_category` = '{$category}' AND public = 1 ORDER BY `post_id` DESC LIMIT 0, 10");

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

    public function getAllRatingsFor($postId)
    {
        $ratings = [];
        $totalRatings = 0;

        $databaseResponse = $this->connection->query( "SELECT * FROM `ratings` WHERE `post_id` = {$postId}");

        while($row = $databaseResponse->fetch_assoc())
        {
            $rating = new Rating();

            $rating->score = $row['rating'];
            $rating->author = $row['author'];

            $totalRatings += $rating->score;

            array_push($ratings, $rating);
        }

        $response = new GetAllRatingsResponse();

        if($totalRatings === 0){
            return $response;
        }

        $response->ratings = $ratings;
        $response->average = round($totalRatings / sizeof($ratings), 1);

        return $response;
    }

    private function validateUsername($username) : ValidationResponse
    {
        $response = new ValidationResponse();

        if(empty($username))
        {
            $response->addError("Username cannot be empty.");
            return $response;
        }

        $response->validatedField = $this->connection->real_escape_string($username);

        return $response;
    }
}
