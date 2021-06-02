<?php

use helperClasses\Auth;
use helperClasses\Session;

function redirect($resource = '/') {
    header("Location: $resource");
    exit();
}

function notFound() {
    redirect('/404');
}

function back() {
    $backurl = $_SERVER['HTTP_REFERER'] ?? '/';
    redirect($backurl);
}

function session() {
    return Session::getInstance();
}

function auth() : Auth {
    return Auth::getInstance();
}
