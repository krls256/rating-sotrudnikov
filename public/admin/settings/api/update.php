<?php

require_once '../../../../config.php';
$request = new \helperClasses\Request();
$repository = new \app\Repositories\Rest\SettingsRestRepository();
$validationHandler = new \app\Http\ValidationHandlers\AdminApiValidationHandler();
$controller = new \app\Http\Controllers\Rest\SettingsRestController($repository, $validationHandler);
$data = $controller->update($request);

echo json_encode(['status' => 'success', 'data' => $data]);
