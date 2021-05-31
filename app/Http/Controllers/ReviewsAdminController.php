<?php


namespace app\Http\Controllers;


use app\Http\Requests\Admin\ReviewDeleteAdminRequest;
use app\Http\Requests\Admin\ReviewEditAdminRequest;
use app\Http\Requests\Admin\ReviewIndexAdminRequest;
use app\Http\Requests\Admin\ReviewModerateRequest;
use app\Http\Requests\Admin\ReviewPublishRequest;
use app\Http\Requests\Admin\ReviewStoreAdminRequest;
use app\Http\Requests\Admin\ReviewUpdateAdminRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Base\BaseCompaniesRepository;
use app\Repositories\Interfaces\IRestRepository;
use app\Repositories\Rest\CompanyRestRepository;


class ReviewsAdminController extends CoreController
{
    protected IRestRepository $repository;


    public function __construct(IRestRepository $rep, ?IValidationHandler $validationHandler = null) {
        parent::__construct($validationHandler);
        $this->repository = $rep;
    }

    public function index(array $request) {
        $this->validate(ReviewIndexAdminRequest::class, $request);
        $count = 25;
        $reviews = $this->repository->getPaginate($count, $request);

        $companiesRepository = new BaseCompaniesRepository();
        $companies = $companiesRepository->getCompaniesNames();
        return [
            'reviews' => $reviews,
            'companies' => $companies
        ];
    }

    public function create() {
        $companyRepository = new CompanyRestRepository();
        return [
            'review' => $this->repository->getCreate(),
            'companies' => $companyRepository->getIndex()
        ];
    }
    public function store(array $request) {
        $this->validate(ReviewStoreAdminRequest::class, $request);

        $res = $this->repository->store($request);
        return $res;
    }

    public function edit(array $request) {
        $companyRepository = new CompanyRestRepository();
        $this->validate(ReviewEditAdminRequest::class, $request);
        $id = $request['id'];
        return [
            'review' => $this->repository->getEdit($id),
            'companies' => $companyRepository->getIndex()
        ];
    }

    public function update(array $request) {
        $this->validate(ReviewUpdateAdminRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->update($id, $request);
        return $res;
    }

    public function publish(array $request) {
        $this->validate(ReviewPublishRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->update($id, ['is_published' => 1]);
        return $res;
    }

    public function delete(array $request) {
        $this->validate(ReviewDeleteAdminRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->delete($id);

        return $res;
    }

    public function moderate(array $request) {
        $this->validate(ReviewModerateRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->update($id, ['is_moderated' => 1]);
        return $res;
    }
}