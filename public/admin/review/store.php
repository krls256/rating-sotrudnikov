<?php

use app\Http\Controllers\ReviewsAdminController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;

require_once '../../../config.php';

$request = Request::capture();
$repository = new ReviewRestRepository();
$controller = new ReviewsAdminController($repository);
$res = $controller->store($request->all());

if($res){
    session()->success('Отзыв успешно создан');
    redirect('/admin/moderation_edit?id='.$res->id);
} else {
    session()->error('Что-то пошло не так');
    back();
}
