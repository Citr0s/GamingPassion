<?php namespace GamingPassion\Mappers;


use GamingPassion\Models\Comment;

class CommentMapper
{

    public static function map($row) : Comment
    {
        $comment = new Comment();

        $comment->createdAt = strtotime($row['timestamp']);
        $comment->authorStatus = $row['comment_author_status'];
        $comment->author = $row['comment_author'];
        $comment->content = $row['comment_content'];

        return $comment;
    }
}