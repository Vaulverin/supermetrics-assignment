<?php
namespace posts\api;


use posts\Post;

class PostsResponse {
    public $page = -1;
    /**
     * @var Post[]
     */
    public $posts = [];
    
    function __construct($page, $posts) {
        $this->page = $page;
        $this->posts = array_map(function($postData) {
            $date = null;
            try {
                $date = new \DateTime($postData['date']);
            } catch (\Exception $e) {
                $date = new \DateTime();
            }
            return new Post($postData['user'], $date, $postData['text']);
        }, $posts);
    }
}