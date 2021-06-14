<?php


use app\Http\Controllers\Pack\ReviewsPackController;
use app\Http\ValidationHandlers\AdminApiValidationHandler;
use app\Repositories\Pack\ReviewsPackRepository;
use helperClasses\Request;

require_once '../../../../config.php';

$request = new Request();
$reviews = $request->get('reviews');
if($reviews) {
    $json = json_decode($reviews, true);
    $request->put('reviews', $json);
}

$repository = new ReviewsPackRepository();
$validationHandler = new AdminApiValidationHandler();
$controller = new ReviewsPackController($repository, $validationHandler);

$res = $controller->storePack($request);

if($res) {
    echo json_encode(['status' => 'success', 'message' => ['Отзывы успешно добавлены']]);
} else {
    echo json_encode(['status' => 'failure', 'message' => ['Что-то пошло не так']]);
}
