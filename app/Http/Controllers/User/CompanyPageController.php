<?php


namespace app\Http\Controllers\User;


use app\Http\Requests\User\UserPageGetRequest;
use app\Http\Requests\User\UserRequestStoreRequest;
use app\Http\Requests\User\UserStoreCommentRequest;
use app\Http\Requests\User\UserStoreReviewRequest;
use app\Modules\ReCaptcha\ReCaptchaModule;
use app\Modules\ReviewRanking\ReviewRankingConstants;
use app\Modules\ReviewRanking\ReviewRankingModule;
use app\Repositories\Rest\CommentRestRepository;
use app\Repositories\Rest\CompanyRestRepository;
use app\Repositories\Rest\ReviewRestRepository;
use app\Repositories\Rest\UserRequestRestRepository;
use app\Repositories\SingleEntity\CompanySingleEntityRepository;
use helperClasses\Request;

class CompanyPageController extends UserController
{
    private string $pageIndex = 'page';
    private string $typeIndex = 'type';
    private $typeArray = ['positive', 'negative'];

    public function index(Request $request, CompanySingleEntityRepository $companyRepository)
    {
        $reviewRankingModule = new ReviewRankingModule();
        $this->prepareIndexRequest($request);
        $this->validate(UserPageGetRequest::class, $request->all());
        $company = $companyRepository->getBy('url', $request->get('name'));
        $id = $company->id;
        $page = (int) $request->get($this->pageIndex);
        $type = $request->get($this->typeIndex);

        $companies = $this->getSideBarCompanies();

        if($type === null) {
            $paginationType = ReviewRankingConstants::DEFAULT_RANKING_INDEX;
        } else if($type === 'positive') {
            $paginationType = ReviewRankingConstants::POSITIVE_RANKING_INDEX;
        } else {
            $paginationType = ReviewRankingConstants::NEGATIVE_RANKING_INDEX;
        }


        $pagination = $reviewRankingModule->getRankingPagination($id, $page, $paginationType);
        // TODO: for admin
        if($company->dev || ($pagination->currentPage() > $pagination->lastPage() && $pagination->currentPage() !== 1))
            notFound();
        return [
            'company' => $company,
            'pagination' => $pagination,
            'companies' => $companies
        ];
    }

    public function store(Request $request) {
        $req = $request->all();
        $this->validate(UserStoreReviewRequest::class, $req);
        $recaptcha_token = $req['recaptcha_token'];
        $recaptchaModule = new ReCaptchaModule();
        $verifying = $recaptchaModule->verify($recaptcha_token);
        if($verifying['status'] === true) {
            $reviewsRepo = new ReviewRestRepository();
            $res = $reviewsRepo->store($req);
            return $res;
        } else {
            return false;
        }
    }

    public function storeComment(Request $request) {
        $req = $request->all();
        $this->validate(UserStoreCommentRequest::class, $req);
        $recaptcha_token = $req['recaptcha_token'];
        $recaptchaModule = new ReCaptchaModule();
        $verifying = $recaptchaModule->verify($recaptcha_token);

        if($verifying['status'] === true) {
            $commentRepo = new CommentRestRepository();
            return $commentRepo->store($req);
        } else {
            return false;
        }
    }

    public function storeUserRequest(Request $request) {
        $req = $request->all();
        $this->validate(UserRequestStoreRequest::class, $req);
        $recaptcha_token = $req['recaptcha_token'];
        $recaptchaModule = new ReCaptchaModule();
        $verifying = $recaptchaModule->verify($recaptcha_token);

        if($verifying['status'] === true) {
            $userRequestRepo = new UserRequestRestRepository();
            return $userRequestRepo->store($req);
        } else {
            return false;
        }
    }

    private function prepareIndexRequest(Request $request): void
    {
        $page = $request->get($this->pageIndex);

        if (!is_numeric($page) || $page < 0)
        {
            $request->put($this->pageIndex, 1);
        }
        $type = $request->get($this->typeIndex);
        if (!in_array($type, $this->typeArray))
        {
            $request->put($this->typeIndex, null);
        }
    }

}
