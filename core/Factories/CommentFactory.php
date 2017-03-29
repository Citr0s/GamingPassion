<?php namespace GamingPassion\Factories;

use GamingPassion\Database;
use GamingPassion\Models\Comment;

class CommentFactory
{
    private $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllCommentsFor($postId)
    {
        $response = [];
        $databaseResponse = $this->database->connection->query( "SELECT * FROM `comments` WHERE `active` = 1 AND `comment_post_id` = '{$postId}' ORDER BY `timestamp` DESC LIMIT 1");

        while($row = $databaseResponse->fetch_assoc())
        {
            $comment = new Comment();

            $comment->createdAt = strtotime($row['timestamp']);
            $comment->authorStatus = $row['comment_author_status'];
            $comment->author = $row['comment_author'];
            $comment->content = $row['comment_content'];

            array_push($response, $comment);
        }

        return $response;
    }
}