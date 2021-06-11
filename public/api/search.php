<?php

use app\Http\Controllers\Search\UserSearchController;
use app\Http\ValidationHandlers\ApiUserReviewStoreHandler;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$validationHandler = new ApiUserReviewStoreHandler();
$controller = new UserSearchController($validationHandler);
$searchResult = $controller->searchCompanies($request);
echo json_encode(['status' => 'success', 'data' => $searchResult->all()]);


