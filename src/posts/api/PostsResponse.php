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
                $date = new \DateTime($postData['created_time']);
            } catch (\Exception $e) {
                $date = new \DateTime();
            }
            return new Post($postData['from_name'], $date, $postData['message']);
        }, $posts);
    }
}