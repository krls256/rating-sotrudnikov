<?php

namespace app\Modules\Publishing\Strategy;

use app\Modules\Publishing\Repositories\CompanyPublishingRepository;
use app\Modules\Publishing\Repositories\ReviewPublishingRepository;

trait StrategyHelperTrait {

    protected function getCompaniesRepository() : CompanyPublishingRepository {
        return new CompanyPublishingRepository();
    }

    protected function getReviewsRepository() : ReviewPublishingRepository {
        return new ReviewPublishingRepository();
    }

    protected function getInformationForStrategy() {
        return $this->getCompaniesRepository()->getCompaniesWithReviewsCounts();
    } 
}
