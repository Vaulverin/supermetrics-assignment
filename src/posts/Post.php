<?php
namespace posts;

class Post {
    protected $user;
    protected $date;
    protected $message;
    
    function __construct(string $user,\DateTime $date, string $message) {
        $this->user = $user;
        $this->date = $date;
        $this->message = $message;
    }
    
    function getUser() { return $this->user; }
    function getDate() { return $this->date; }
    function getMessage() { return $this->message; }
}