<?php

use app\Http\Controllers\User\CompanyPageController;
use app\Http\ValidationHandlers\ApiUserReviewStoreHandler;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$validationHandler = new ApiUserReviewStoreHandler();
$controller = new CompanyPageController($validationHandler);
$req = $controller->storeComment($request);

if($req)
echo json_encode(['status' => 'success', 'messages' => ['Спасибо! Комментарий успешно сохранен и будет опубликован после модерации.']]);
else
echo json_encode(['status' => 'failure', 'errors' => ['Что-то пошло не так. Пожалуйста, отправьте форму позже.']]);
