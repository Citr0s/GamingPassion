<?php namespace GamingPassion\Services;

use GamingPassion\Factories\CommentFactory;


class CommentService
{
    private $commentFactory;

    function __construct(CommentFactory $commentFactory)
    {
        $this->commentFactory = $commentFactory;
    }

    public function getAllFor($postId){
        return  $this->commentFactory->getAllCommentsFor($postId);
    }
}