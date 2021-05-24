<?php

use app\Http\Controllers\ReviewsAdminController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;

require_once '../../../config.php';


$request = Request::capture()->all();
$repository = new ReviewRestRepository();
$controller = new ReviewsAdminController($repository);
$res = $controller->update($request);

if($res !== false) {
    echo json_encode(['status' => 'ok', 'updated' => $res]);
} else {
    echo json_encode(['status' => 'error']);
}