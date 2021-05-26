<?php


namespace app\Http\Controllers\User;


use app\Http\Requests\User\UserPageGetRequest;
use app\Modules\ReviewRanking\ReviewRankingConstants;
use app\Modules\ReviewRanking\ReviewRankingModule;
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
            'pagination' => $pagination
        ];
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