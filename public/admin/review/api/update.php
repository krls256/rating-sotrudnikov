<?php


use app\Http\Controllers\ReviewsAdminController;
use app\Http\ValidationHandlers\AdminApiValidationHandler;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;

require_once '../../../../config.php';

$request = Request::capture()
    ->all();
$repository = new ReviewRestRepository();
$validationHelper = new AdminApiValidationHandler();
$controller = new ReviewsAdminController($repository, $validationHelper);
$res = $controller->update($request);

if($res) {
    echo json_encode(['status' => 'success', 'message' => ['Отзыв успешно обновлен']]);
} else {
    $err = session()->getError();
    session()->resetError();
    if($err) {
        $message = array_merge(['Что-то пошло не так'], $err);
    } else {
        $message = ['Что-то пошло не так'];
    }
    echo json_encode(['status' => 'failure', 'message' => $message]);
}