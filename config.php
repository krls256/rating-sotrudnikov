<?php

session_start();
define('ROOT_DIR', __DIR__);
require_once "vendor/autoload.php";
require_once "credentials.php";
require_once 'helpers/index.php';

use database\Database;

$db = new Database($dbCredentials);
