<?php


namespace posts;


use posts\api\ApiInterface;

class PostsIterator implements \Iterator {
    
    protected $postsApi;
    protected $key = 0;
    protected $page = 1;
    protected $buffer = [];
    
    function __construct(ApiInterface $postsApi) {
        $this->postsApi = $postsApi;
    }
    
    public function current() {
        return $this->buffer[$this->key()];
    }
    
    public function next() {
        $this->key++;
    }
    
    public function key() {
        return $this->key;
    }
    
    public function rewind() {
        $this->key = 0;
    }
    
    public function valid(): bool {
        if ($this->key < count($this->buffer)) {
            return true;
        }
        $this->setNextBuffer();
        return count($this->buffer) > 0;
    }
    
    public function reset() {
        $this->page = 1;
        $this->buffer = [];
        $this->rewind();
    }
    
    protected function setNextBuffer() {
        $this->buffer = $this->postsApi->fetchPosts(++$this->page)->posts;
        $this->rewind();
    }
}