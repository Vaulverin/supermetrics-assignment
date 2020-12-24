<?php


namespace posts\stats;


use posts\Post;

class AverageNumberOfPostsPerUserPerMonth implements StatInterface {
    
    protected $data = [];
    protected $result = [];
    
    function getName(): string {
        return 'Average number of posts per user per month';
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
                'users' => [],
                'postsCount' => 0
            ];
        }
        $user = $post->getUser();
        if (!in_array($user, $this->data[$year][$month]['users'])) {
            $this->data[$year][$month]['users'][] = $user;
        }
        $this->data[$year][$month]['postsCount'] ++;
        $this->result[$year][$month] = $this->data[$year][$month]['postsCount']
            / count($this->data[$year][$month]['users']);
    }
    
    function getResult(): array {
        return $this->result;
    }
}