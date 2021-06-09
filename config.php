<?php

session_start();
define('ROOT_DIR', __DIR__);
define('DEBUG', false);
require_once "vendor/autoload.php";
require_once 'helpers/index.php';

use database\Database;
/** @var Database $db */
$db = Database::getInstance();
$web = php_sapi_name() !== 'cli';


if($web) {
    $pipeline = new \app\Middleware\Pipeline();

    $pipeline->pipe(\app\Middleware\AuthMiddleware::class);
    $pipeline->run();

}
