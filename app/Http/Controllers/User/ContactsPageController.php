<?php


namespace app\Http\Controllers\User;


use helperClasses\Request;

class ContactsPageController extends UserController
{
    public function index(Request $request) : array {
        $companies = $this->getSideBarCompanies();
        return [
            'companies' => $companies
        ];
    }
}
