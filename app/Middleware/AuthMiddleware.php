<?php


namespace app\Middleware;


use app\Repositories\SingleEntity\UserSingleEntityRepository;
use helperClasses\Auth;
use helperClasses\Hash;
use helperClasses\Request;
use helperClasses\Session;

class AuthMiddleware extends CoreMiddleware
{
    protected $adminPart = '/admin';
    protected $loginFormPart = '/admin/login';

    public function handle(Request $request): bool
    {
        $isAuthorized = $this->isAuthorized($request->session());
        $isOnAdminPage = $this->isOnAdminPage($request->url()->get('path'));
        $isOnLoginPage = $this->isOnLoginPage($request->url()->get('path'));
        if($isAuthorized === false && $isOnAdminPage === true) {
            redirect($this->loginFormPart);
        }
        if($isAuthorized === true &&  $isOnLoginPage === true) {
            redirect($this->adminPart);
        }
        if($isAuthorized) {
            auth()->auth();
        }
        return true;
    }

    protected function isAuthorized(Session $session) : bool {
        $login = $session->get(Auth::LOGIN_FIELD);
        $password = $session->get(Auth::PASSWORD_FIELD);
        if($login === null) {
            return false;
        }
        $userRepo = new UserSingleEntityRepository();
        $user = $userRepo->getUserByLogin($login);
        if($user === null)
            return false;
        return Hash::compareHash($password, $user->pass);

    }

    protected function isOnAdminPage($path) : bool {
        return strpos($path, $this->adminPart) !== false && strpos($path, $this->loginFormPart) === false;
    }

    protected function isOnLoginPage($path) {
        return strpos($path, $this->loginFormPart) !== false;
    }
}
