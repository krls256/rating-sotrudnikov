<?php

use app\Http\Controllers\Rest\ReviewsRestController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;

require_once '../../../config.php';


$request = Request::capture()->all();
$repository = new ReviewRestRepository();
$controller = new ReviewsRestController($repository);
$res = $controller->update($request);

if($res){
    session()->success('Отзыв успешно обновлен');
    redirect('/admin/moderation_edit?id='.$request['id']);
} else {
    session()->error('Что-то пошло не так');
    back();
}
