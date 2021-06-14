<?php


namespace app\Http\Controllers\Rest;


use app\Http\Requests\Rest\Comment\CommentDeleteRestRequest;
use app\Http\Requests\Rest\Comment\CommentIndexRestRequest;
use app\Http\Requests\Rest\Comment\CommentPublishRestRequest;
use app\Http\Requests\Rest\Comment\CommentUpdateRestRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Base\BaseCompaniesRepository;
use app\Repositories\Interfaces\IRestRepository;
use helperClasses\Request;

class CommentRestController extends RestController
{
    public function __construct(IRestRepository $rep, ?IValidationHandler $validationHandler = null) {
        parent::__construct($rep, $validationHandler);
    }

    public function index(Request $request) {
        $req = $request->all();
        $this->validate(CommentIndexRestRequest::class, $req);
        $count = 25;
        $comments = $this->repository->getPaginate($count, $req);

        $companiesRepository = new BaseCompaniesRepository();
        $companies = $companiesRepository->getCompaniesNames();
        return [
            'comments' => $comments,
            'companies' => $companies
        ];
    }

    public function update(Request $request) {
        $req = $request->all();
        $this->validate(CommentUpdateRestRequest::class, $req);
        $id = $req['id'];
        return $this->repository->update($id, $req);
    }

    public function moderate(Request $request) {
        $req = $request->all();
        $this->validate(CommentPublishRestRequest::class, $req);
        $id = $req['id'];
        return $this->repository->update($id, ['is_moderated' => 1]);
    }

    public function delete(Request $request) {
        $req = $request->all();
        $this->validate(CommentDeleteRestRequest::class, $req);
        $id = $req['id'];
        return $this->repository->delete($id);
    }
}
