<?php namespace GamingPassion\Mappers;

use GamingPassion\Models\Post;

class PostMapper
{
    public static function map($record) : Post
    {
        $post = new Post();

        $post->id = $record['post_id'];
        $post->title = $record['post_title'];
        $post->author = $record['post_author'];
        $post->content = $record['post_content'];
        $post->createdAt = strtotime($record['timestamp']);
        $post->thumbnail = $record['thumbnail'];
        $post->category = $record['post_category'];

        if($post->category == 'news'){
            $post->category = 'news';
        }elseif($post->category == 'recenzja'){
            $post->category = 'reviews';
        }elseif($post->category == 'gameplay'){
            $post->category = 'gameplay';
        }

        return $post;
    }
}