<?php

use app\Http\Controllers\Rest\ReviewsRestController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;


require_once '../../../config.php';

$request = Request::capture();
$repository = new ReviewRestRepository();
$controller = new ReviewsRestController($repository);
$res = $controller->moderate($request->all());

$company_id = $request->get('company_id');
$url = $company_id ? "/admin/moderation?id=$company_id" : '/admin/moderation';
if($res){
    session()->success('Отзыв успешно прошел модерацию');
    redirect($url);
} else {
    session()->error('Что-то пошло не так');
    back();
}
