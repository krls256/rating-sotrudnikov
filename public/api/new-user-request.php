<?php

use app\Http\Controllers\User\CompanyPageController;
use app\Http\ValidationHandlers\ApiUserReviewStoreHandler;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$validationHandler = new ApiUserReviewStoreHandler();
$controller = new CompanyPageController($validationHandler);
$res = $controller->storeUserRequest($request);
if($res)
echo json_encode(['status' => 'success', 'messages' => ['Спасибо! Заявка успешно принята и будет передана компании.']]);
else
echo json_encode(['status' => 'failure', 'errors' => ['Что-то пошло не так. Пожалуйста, отправьте форму позже.']]);
