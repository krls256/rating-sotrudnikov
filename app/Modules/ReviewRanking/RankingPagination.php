<?php


namespace app\Modules\ReviewRanking;


use Illuminate\Support\Collection;

class RankingPagination extends Collection
{
    protected Collection $additionalData;

    public function __construct($items, $additionalData)
    {
        parent::__construct($items);
        $this->additionalData = collect($additionalData);
    }

    public function lastPage() {
        return $this->additionalData->get('lastPage');
    }

    public function currentPage() {
        return $this->additionalData->get('currentPage');
    }

    public function firstPage() {
        return $this->additionalData->get('firstPage');
    }

    public function printPagination($type, $companyUrl) {
        if ($type)
            $postfix = "/$type";
        else
            $postfix = '';



        $currentPage = $this->currentPage();
        include_view('/includes/reviewPagination.php', [
            'count' => $this->count(),
            'currentPage' => $currentPage,
            'lastPage' => $this->lastPage(),
            'start' => $currentPage - 3,
            'end' => $currentPage + 3,
            'prefix' => '/otzyvy-sotrudnikov-' . $companyUrl . '/',
            'postfix' => $postfix . '#rew_block'
            ]);
    }
}
