<?php

use app\Http\Controllers\CommentAdminController;
use app\Http\ValidationHandlers\AdminApiValidationHandler;
use app\Repositories\Rest\CommentRestRepository;
use helperClasses\Request;

require_once '../../../../config.php';


$request = new Request();
$repository = new CommentRestRepository();
$validationHelper = new AdminApiValidationHandler();
$controller = new CommentAdminController($repository, $validationHelper);
$res = $controller->update($request);

if($res)
echo json_encode(['status' => 'success', 'message' => ['Комментарий успешно обновлен']]);
else {
    $err = session()->getError();
    session()->resetError();
    if($err) {
        $message = array_merge(['Что-то пошло не так'], $err);
    } else {
        $message = ['Что-то пошло не так'];
    }
    echo json_encode(['status' => 'failure', 'message' => $message]);
}
