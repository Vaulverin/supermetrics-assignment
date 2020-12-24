<?php


namespace posts\stats;


use posts\Post;

class AverageCharLengthPerMonth implements StatInterface {
    
    protected $data = [];
    protected $result = [];
    
    function getName(): string {
        return 'Average character length of posts per month';
    }
    
    function accumulatePost(Post $post): void {
        $postDate = $post->getDate();
        $year = $postDate->format('Y');
        $month = $postDate->format('F');
        if (!isset($this->data[$year])) {
            $this->data[$year] = [];
            $this->result[$year] = [];
        }
        if (!isset($this->data[$year][$month])) {
            $this->data[$year][$month] = [
                'charLength' => 0,
                'postsCount' => 0
            ];
        }
        $this->data[$year][$month]['charLength'] += strlen($post->getMessage());
        $this->data[$year][$month]['postsCount'] ++;
        $this->result[$year][$month] = $this->data[$year][$month]['charLength']
            / $this->data[$year][$month]['postsCount'];
    }
    
    function getResult(): array {
        return $this->result;
    }
}