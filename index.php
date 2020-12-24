<?php

use posts\api\ApiInterface;
use posts\PostsIterator;
use posts\stats\StatInterface;

const API_HOST = 'https://api.supermetrics.com';
const CLIENT_ID = 'ju16a6m81mhid5ue1z3v2g0uh';
const CLIENT_EMAIL = 'vauulin@gmail.com';
const CLIENT_NAME = 'Aleksandr Vaulin';

/** @var StatInterface[] $stats */
$stats = [];
/** @var ApiInterface $postsApi */
$postsApi = null;
$postsIterator = new PostsIterator($postsApi);

foreach ($postsIterator as $post) {
    foreach ($stats as $stat) {
        $stat->accumulatePost($post);
    }
}

$result = [];

foreach ($stats as $stat) {
    $result[$stat->getName()] = $stat->getResult();
}

echo json_encode($result);
echo PHP_EOL;