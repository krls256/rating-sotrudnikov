<?php

use app\Http\Controllers\Rest\CompanyRestController;
use app\Repositories\Rest\CompanyRestRepository;
use helperClasses\Request;

require_once '../../../config.php';

$request = new Request();
$repository = new CompanyRestRepository();
$controller = new CompanyRestController($repository);

$res = $controller->update($request);
$id = $request->get('id');
if($res) {
    session()->success('Компания успешно обновлена');
    redirect("/admin/edit-company?id=$id");
} else {
    session()->error('Что-то пошло не так');
    back();
}
