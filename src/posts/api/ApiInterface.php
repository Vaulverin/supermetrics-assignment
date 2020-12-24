<?php
namespace posts\api;


interface ApiInterface {
    function fetchPosts(int $page): PostsResponse;
}