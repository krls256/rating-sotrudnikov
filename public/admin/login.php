<?php

use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$controller = new \app\Http\Controllers\AuthController();


if($request->method() === 'POST') {
    $controller->auth($request);
}

?>

<!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Авторизация</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>
<body>
<div class="login card">
	<h1 class="login__logo">RATING <span>REMONT</span></h1>
	<?php include_view('includes/adminMessageBar.php'); ?>
	<div class="login__comment">Вход в административную панель</div>
	<form class="login__form" action="" method="post">
		<input type="text" name="admin_login" placeholder="Логин">
		<input type="password" name="admin_password" placeholder="Пароль">
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary" type="submit">Войти</button>
        </div>
	</form>
</div>
<script type="text/javascript" src="/js/admin.js"></script>
</body>
</html>
