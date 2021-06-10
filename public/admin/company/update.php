<?php

use app\Http\Controllers\CRUD\CompanyCRUDController;
use app\Repositories\Rest\CompanyRestRepository;
use helperClasses\Request;

require_once '../../../config.php';

$request = new Request();
$repository = new CompanyRestRepository();
$controller = new CompanyCRUDController($repository);

$res = $controller->update($request);
$id = $request->get('id');
if($res) {
    session()->success('Компания успешно обновлена');
    redirect("/admin/edit-company?id=$id");
} else {
    session()->error('Что-то пошло не так');
    back();
}
