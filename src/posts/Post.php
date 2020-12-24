<?php
namespace posts;

class Post {
    protected $user;
    protected $date;
    protected $text;
    
    function __construct(string $user,\DateTime $date, string $text) {
        $this->user = $user;
        $this->date = $date;
        $this->text = $text;
    }
    
    function getUser() { return $this->user; }
    function getDate() { return $this->date; }
    function getText() { return $this->text; }
}