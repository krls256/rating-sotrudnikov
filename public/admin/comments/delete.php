<?php

use app\Http\Controllers\Rest\CommentRestController;
use app\Repositories\Rest\CommentRestRepository;
use helperClasses\Request;

require_once '../../../config.php';

$request = new Request();
$repository = new CommentRestRepository();
$controller = new CommentRestController($repository);
$res = $controller->delete($request);
$url = '/admin/comments-table';

if($res){
    session()->success('Комментарий успешно удален');
    redirect($url);
} else {
    session()->error('Что-то пошло не так');
    back();
}
