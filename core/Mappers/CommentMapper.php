<?php namespace GamingPassion\Mappers;


use GamingPassion\Models\Comment;

class CommentMapper
{

    public static function map($record) : Comment
    {
        $comment = new Comment();

        $comment->createdAt = strtotime($record['timestamp']);
        $comment->authorStatus = $record['comment_author_status'];
        $comment->author = $record['comment_author'];
        $comment->content = $record['comment_content'];

        return $comment;
    }
}