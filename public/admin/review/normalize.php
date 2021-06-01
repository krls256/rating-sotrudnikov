<?php

use app\Http\Controllers\ReviewsAdminController;
use app\Repositories\Rest\ReviewRestRepository;

require_once '../../../config.php';

$repository = new ReviewRestRepository();
$controller = new ReviewsAdminController($repository);

$controller->normalize();

session()->success('База успешно нормализована');
back();
