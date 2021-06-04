<?php

use app\Http\Controllers\User\CompanyPageController;
use app\Http\ValidationHandlers\ApiUserReviewStoreHandler;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$validationHandler = new ApiUserReviewStoreHandler();
$controller = new CompanyPageController($validationHandler);
$res = $controller->store($request);

if($res)
echo json_encode(['status' => 'success', 'messages' => ['Спасибо! Отзыв успешно сохранен и после модерации будет 
опубликован.']]);
else
echo json_encode(['status' => 'failure', 'errors' => ['Что-то пошло не так. Пожалуйста, отправьте форму позже.']]);

