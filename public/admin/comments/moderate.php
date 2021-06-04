<?php

use app\Http\Controllers\CommentAdminController;
use app\Repositories\Rest\CommentRestRepository;
use helperClasses\Request;

require_once '../../../config.php';

$request = new Request();
$repository = new CommentRestRepository();
$controller = new CommentAdminController($repository);
$res = $controller->moderate($request);
$url = '/admin/comments-table';

if($res){
    session()->success('Комментарий успешно прошел модерацию');
    redirect($url);
} else {
    session()->error('Что-то пошло не так');
    back();
}
