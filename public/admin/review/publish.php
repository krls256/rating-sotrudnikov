<?php


use app\Http\Controllers\ReviewsAdminController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;


require_once '../../../config.php';

$request = Request::capture();
$repository = new ReviewRestRepository();
$controller = new ReviewsAdminController($repository);
$res = $controller->publish($request->all());


if($res){
    session()->success('Отзыв успешно опубликован');
    redirect('/admin/moderation');
} else {
    session()->error('Что-то пошло не так');
    back();
}