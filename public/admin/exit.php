<?php

use app\Http\Controllers\AuthController;

require_once '../../config.php';

$controller = new AuthController();
$controller->exit();
