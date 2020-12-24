<?php


namespace posts\stats;


use posts\Post;

class TotalPostsSplitByWeekNumber implements StatInterface {
    
    protected $result = [];
    
    function getName(): string {
        return 'Total posts split by week number';
    }
    
    function accumulatePost(Post $post): void {
        $postDate = $post->getDate();
        $year = $postDate->format('Y');
        $week = $postDate->format('W');
        if (!isset($this->result[$year])) {
            $this->result[$year] = [];
        }
        if (!isset($this->result[$year][$week])) {
            $this->result[$year][$week] = 0;
        }
        $this->result[$year][$week]++;
    }
    
    function getResult(): array {
        $result = $this->result;
        $result['total'] = array_reduce($result, function ($carry, $item) {
            return $carry + array_sum($item);
        }, 0);
        return $result;
    }
}