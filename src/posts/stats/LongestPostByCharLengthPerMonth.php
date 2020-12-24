<?php


namespace posts\stats;


use posts\Post;

class LongestPostByCharLengthPerMonth implements StatInterface {
    
    protected $result = [];
    
    function getName(): string {
        return 'Longest post by character length per month';
    }
    
    function accumulatePost(Post $post): void {
        $postDate = $post->getDate();
        $year = $postDate->format('Y');
        $month = $postDate->format('F');
        if (!isset($this->result[$year])) {
            $this->result[$year] = [];
        }
        $postLength = strlen($post->getMessage());
        $needOverwrite = isset($this->result[$year][$month]) && $this->result[$year][$month] < $postLength
            || !isset($this->result[$year][$month]);
        if ($needOverwrite) {
            $this->result[$year][$month] = $postLength;
        }
    }
    
    function getResult(): array {
        return $this->result;
    }
}