<?php
namespace posts\stats;


use posts\Post;

interface StatInterface {
    function getName(): string;
    function accumulatePost(Post $post): void;
    function getResult(): array;
}