<?php


namespace app\Http\Controllers\Rest;


use app\Http\Requests\Rest\Review\ReviewDeleteRestRequest;
use app\Http\Requests\Rest\Review\ReviewEditRestRequest;
use app\Http\Requests\Rest\Review\ReviewIndexRestRequest;
use app\Http\Requests\Rest\Review\ReviewModerateRestRequest;
use app\Http\Requests\Rest\Review\ReviewPublishRestRequest;
use app\Http\Requests\Rest\Review\ReviewStoreRestRequest;
use app\Http\Requests\Rest\Review\ReviewUpdateRestRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Modules\Publishing\PublishingConstants;
use app\Modules\Publishing\PublishingModule;
use app\Repositories\Base\BaseCompaniesRepository;
use app\Repositories\Interfaces\IRestRepository;
use app\Repositories\Rest\CompanyRestRepository;


class ReviewsRestController extends RestController
{
    public function __construct(IRestRepository $rep, ?IValidationHandler $validationHandler = null) {
        parent::__construct($rep, $validationHandler);
    }

    public function index(array $request) {
        $this->validate(ReviewIndexRestRequest::class, $request);
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
        $this->validate(ReviewStoreRestRequest::class, $request);

        $res = $this->repository->store($request);
        return $res;
    }

    public function edit(array $request) {
        $companyRepository = new CompanyRestRepository();
        $this->validate(ReviewEditRestRequest::class, $request);
        $id = $request['id'];
        return [
            'review' => $this->repository->getEdit($id),
            'companies' => $companyRepository->getIndex()
        ];
    }

    public function update(array $request) {
        $this->validate(ReviewUpdateRestRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->update($id, $request);
        return $res;
    }

    public function publish(array $request) {
        $this->validate(ReviewPublishRestRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->update($id, ['is_published' => 1]);
        return $res;
    }

    public function delete(array $request) {
        $this->validate(ReviewDeleteRestRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->delete($id);

        return $res;
    }

    public function moderate(array $request) {
        $this->validate(ReviewModerateRestRequest::class, $request);
        $id = $request['id'];
        $res = $this->repository->update($id, ['is_moderated' => 1]);
        return $res;
    }

    public function normalize() {
        $publishingModule = new PublishingModule();
        $publishingModule->normalize(PublishingConstants::JSON_SCHEMA_ORIENTED_INDEX);
    }
}
