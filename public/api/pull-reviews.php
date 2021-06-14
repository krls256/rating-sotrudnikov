<?php


use app\Http\Controllers\Rest\ReviewsRestController;
use app\Repositories\Rest\ReviewRestRepository;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$repository = new ReviewRestRepository();
$controller = new ReviewsRestController($repository);

