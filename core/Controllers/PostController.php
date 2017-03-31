<?php namespace GamingPassion\Controllers;

use GamingPassion\Factories\PostFactory;
use GamingPassion\Services\PostService;

class PostController extends Controller
{
    public static function all()
    {
        $postService = new PostService(new PostFactory(self::database()));
        return $postService->getAll();
    }

    public static function single($id)
    {
        $postService = new PostService(new PostFactory(self::database()));
        return $postService->getSinglePost($id);
    }

    public static function forCategory($category)
    {
        $postService = new PostService(new PostFactory(self::database()));
        return $postService->getAllFor($category);
    }

    public static function archive()
    {
        $postService = new PostService(new PostFactory(self::database()));
        return $postService->getArchived();
    }
}