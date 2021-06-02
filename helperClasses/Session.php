<?php


namespace helperClasses;

use patterns\Singleton;

class Session extends Singleton
{
    public function get($k) {
        return isset($_SESSION[$k]) ? $_SESSION[$k] : null;
    }

    public function set($k, $v) {
        $_SESSION[$k] = $v;

        return true;
    }

    public function delete($k) : void {
        if(isset($_SESSION[$k])) {
            unset($_SESSION[$k]);
        }
    }


    public function error($v) {
        $_SESSION['error'][] = $v;
        return true;
    }

    public function getError() {
        return isset($_SESSION['error']) ? $_SESSION['error'] : null;
    }

    public function resetError() {
        unset($_SESSION['error']);
        return true;
    }

    public function success($v) {
        $_SESSION['success'][] = $v;
        return true;
    }
    public function getSuccess() {
        return isset($_SESSION['success']) ? $_SESSION['success'] : null;
    }

    public function resetSuccess() {
        unset($_SESSION['success']);
        return true;
    }
    public function all() {
        return $_SESSION;
    }
}
