<?php


namespace app\Http\Controllers;


use app\Http\Requests\Admin\AuthRequest;
use app\Repositories\SingleEntity\UserSingleEntityRepository;
use helperClasses\Auth;
use helperClasses\Hash;
use helperClasses\Request;

class AuthController extends CoreController
{
    public function auth(Request $request)
    {
        $this->validate(AuthRequest::class, $request->all());
        $userRepo = new UserSingleEntityRepository();
        $login = $request->get(Auth::LOGIN_FIELD);
        $password = $request->get(Auth::PASSWORD_FIELD);
        $user = $userRepo->getUserByLogin($login);
        if($user === null) {
            $this->reactOnFailure();
        }
        $newHash = getHash($password);
        $equalHash = Hash::compareHash($newHash, $user->pass);
        if($equalHash === false) {
            $this->reactOnFailure();
        }

        session()->set(Auth::LOGIN_FIELD, $login);
        session()->set(Auth::PASSWORD_FIELD, $newHash);
        redirect('/admin');
    }

    public function exit() {
        session()->delete(Auth::LOGIN_FIELD);
        session()->delete(Auth::PASSWORD_FIELD);
        redirect('/');
    }

    protected function reactOnFailure()
    {
        session()->error('Неверный логин или пароль');
        back();
    }
}
