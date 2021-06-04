<?php


namespace app\Http\Controllers;


use app\Http\Requests\Admin\CommentDeleteAdminRequest;
use app\Http\Requests\Admin\CommentIndexAdminRequest;
use app\Http\Requests\Admin\CommentPublishAdminRequest;
use app\Http\Requests\Admin\CommentUpdateAdminRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Interfaces\IRestRepository;
use helperClasses\Request;

class CommentAdminController extends CoreController
{
    protected IRestRepository $repository;


    public function __construct(IRestRepository $rep, ?IValidationHandler $validationHandler = null) {
        parent::__construct($validationHandler);
        $this->repository = $rep;
    }

    public function index(Request $request) {
        $req = $request->all();
        $this->validate(CommentIndexAdminRequest::class, $req);
        $count = 25;
        $comments = $this->repository->getPaginate($count, $req);

        return [
            'comments' => $comments
        ];
    }

    public function update(Request $request) {
        $req = $request->all();
        $this->validate(CommentUpdateAdminRequest::class, $req);
        $id = $req['id'];
        return $this->repository->update($id, $req);
    }

    public function moderate(Request $request) {
        $req = $request->all();
        $this->validate(CommentPublishAdminRequest::class, $req);
        $id = $req['id'];
        return $this->repository->update($id, ['is_moderated' => 1]);
    }

    public function delete(Request $request) {
        $req = $request->all();
        $this->validate(CommentDeleteAdminRequest::class, $req);
        $id = $req['id'];
        return $this->repository->delete($id);
    }
}
