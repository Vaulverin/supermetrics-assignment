<?php
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    include './src/' . $class_name . '.php';
});

use posts\api\SupermetricsApi;
use posts\stats\StatInterface;

const API_HOST = 'https://api.supermetrics.com';
const CLIENT_ID = 'ju16a6m81mhid5ue1z3v2g0uh';
const CLIENT_EMAIL = 'vauulin@gmail.com';
const CLIENT_NAME = 'Aleksandr Vaulin';

/** @var StatInterface[] $stats */
$stats = [];
$postsApi = new SupermetricsApi(
    API_HOST,
    CLIENT_ID,
    CLIENT_EMAIL,
    CLIENT_NAME
);

$app = new Application($postsApi, $stats);

$app->start();