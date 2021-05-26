<?php


use app\Http\Controllers\ReviewsAdminController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;


require_once '../../../config.php';

$request = Request::capture();
$repository = new ReviewRestRepository();
$controller = new ReviewsAdminController($repository);
$res = $controller->delete($request->all());

$company_id = $request->get('company_id');
$url = $company_id ? "/admin/moderation?id=$company_id" : '/admin/moderation';
if($res){
    session()->success('Отзыв успешно Удален');
    redirect($url);
} else {
    session()->error('Что-то пошло не так');
    back();
}