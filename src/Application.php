<?php


use posts\api\ApiInterface;
use posts\PostsIterator;
use posts\stats\StatInterface;

class Application {
    /**
     * @var ApiInterface
     */
    protected $postsApi;
    /**
     * @var StatInterface[]
     */
    protected $stats;
    
    /**
     * Application constructor.
     * @param ApiInterface $postsApi
     * @param StatInterface[] $stats
     */
    function __construct(ApiInterface $postsApi, array $stats) {
        $this->postsApi = $postsApi;
        $this->stats = $stats;
    }
    
    function calculateStats(): array {
        $postsIterator = new PostsIterator($this->postsApi);
    
        foreach ($postsIterator as $post) {
            foreach ($this->stats as $stat) {
                $stat->accumulatePost($post);
            }
        }
    
        $result = [];
        foreach ($this->stats as $stat) {
            $result[$stat->getName()] = $stat->getResult();
        }
        return $result;
    }
    
    function start() {
        $statsResult = $this->calculateStats();
        echo json_encode($statsResult, JSON_PRETTY_PRINT);
        echo PHP_EOL;
    }
}