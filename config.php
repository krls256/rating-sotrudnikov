<?php

session_start();
define('ROOT_DIR', __DIR__);
require_once "vendor/autoload.php";
require_once "credentials.php";
require_once 'helpers/index.php';

use database\Database;

$db = Database::getInstance($dbCredentials);
$web = true;

if($web) {
    $pipeline = new \app\Middleware\Pipeline();

    $pipeline->pipe(\app\Middleware\AuthMiddleware::class);
    $pipeline->run();

}
