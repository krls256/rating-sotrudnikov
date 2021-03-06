<?php

use app\Http\Controllers\Rest\ReviewsRestController;
use app\Repositories\Rest\ReviewRestRepository;

require_once '../../../config.php';

$repository = new ReviewRestRepository();
$controller = new ReviewsRestController($repository);

$controller->normalize();

session()->success('База успешно нормализована');
back();
