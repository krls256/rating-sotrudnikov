<?php

namespace app\Modules\Publishing\Strategy;

use app\Modules\Publishing\PublishingConstants;

class DeltaOrientedPublishingStrategy implements IPublishingStrategy
{
    use StrategyHelperTrait;

    protected $key_pp = 'reviews_published_positive_count';
    protected $key_pnp = 'reviews_published_negative_count';
    protected $key_npp = 'reviews_not_published_positive_count';
    protected $key_npnp = 'reviews_not_published_negative_count';

    public function newPublishing() : void
    {
        $repository = $this->getReviewsRepository();
        $companies = $this->getInformationForStrategy();
        /** For main Company */
        $mainCompany = $companies[PublishingConstants::SPECIAL_COMPANY_NAME];
        $alreadyPositive = $mainCompany[$this->key_pp];
        $alreadyNegative = $mainCompany[$this->key_pnp];
        $canBePositive = $mainCompany[$this->key_npp];
        $canBeNegativeBase = $mainCompany[$this->key_npnp];
        $canBeNegative = $this->canPublishNegativeReviews($alreadyPositive + $canBePositive, $alreadyNegative,
            PublishingConstants::NECESSARY_POSITIVE_TO_NEGATIVE_RATIO_FOR_MAIN_COMPANY);
        if ($canBePositive > 0)
            $repository->publishReviews($mainCompany->id, 1, $canBePositive);
        if ($canBeNegative > 0)
            $repository->publishReviews($mainCompany->id, 0, min($canBeNegative, $canBeNegativeBase));

        $totalMainDelta = $alreadyPositive + $canBePositive - $alreadyNegative - $canBeNegative -
            PublishingConstants::MAX_PERMISSIBLE_DELTA;

        /** For Others Company */

        foreach ($companies as $company_name => $company)
        {
            if ($company_name !== PublishingConstants::SPECIAL_COMPANY_NAME)
            {
                $alreadyPositive = $company[$this->key_pp];
                $alreadyNegative = $company[$this->key_pnp];
                $maxPositive = $company[$this->key_npp];
                $maxNegative = $company[$this->key_npnp];
                $canBeNegative = $maxNegative;
                $canBePositive = $this->canPublishPositive($alreadyPositive, $alreadyNegative + $canBeNegative,
                    $totalMainDelta);
                if ($canBePositive > 0)
                    $repository->publishReviews($company->id, 1, min($canBePositive, $maxPositive));
                if ($canBeNegative > 0)
                    $repository->publishReviews($company->id, 0, $canBeNegative);

            }
        }
    }

    public function normalizePublishing(): void
    {
        $toUnpublish = 0;
        $repository = $this->getReviewsRepository();
        $companies = $this->getInformationForStrategy();
        $mainCompany = $companies[PublishingConstants::SPECIAL_COMPANY_NAME];
        $alreadyPositive = $mainCompany[$this->key_pp];
        $alreadyNegative = $mainCompany[$this->key_pnp];
        $canBePositive = $mainCompany[$this->key_npp];
        $canBeNegativeBase = $mainCompany[$this->key_npnp];
        $canBeNegative = $this->canPublishNegativeReviews($alreadyPositive + $canBePositive, $alreadyNegative,
            PublishingConstants::NECESSARY_POSITIVE_TO_NEGATIVE_RATIO_FOR_MAIN_COMPANY);
        if ($canBePositive > 0)
            $repository->publishReviews($mainCompany->id, 1, $canBePositive);
        if ($canBeNegative > 0) {
            $repository->publishReviews($mainCompany->id, 0, min($canBeNegative, $canBeNegativeBase));
        } else {
            $toUnpublish = $this->findCountToUnpublishNegative($alreadyPositive, $alreadyNegative,
                PublishingConstants::NECESSARY_POSITIVE_TO_NEGATIVE_RATIO_FOR_MAIN_COMPANY);
            if($toUnpublish > 0)
                $repository->unpublishReviews($mainCompany->id, 0, $toUnpublish);
        }

        $totalMainDelta = $alreadyPositive + $canBePositive - $alreadyNegative - $canBeNegative -
            PublishingConstants::MAX_PERMISSIBLE_DELTA + $toUnpublish;

        foreach ($companies as $company_name => $company)
        {
            if ($company_name !== PublishingConstants::SPECIAL_COMPANY_NAME)
            {
                $alreadyPositive = $company[$this->key_pp];
                $alreadyNegative = $company[$this->key_pnp];
                $maxPositive = $company[$this->key_npp];
                $maxNegative = $company[$this->key_npnp];
                $canBeNegative = $maxNegative;
                $canBePositive = $this->canPublishPositive($alreadyPositive, $alreadyNegative + $canBeNegative,
                    $totalMainDelta);
                if ($canBePositive > 0)
                    $repository->publishReviews($company->id, 1, min($canBePositive, $maxPositive));
                else {
                    $toUnpublish = $this->findCountToUnpublishPositive($alreadyPositive, $alreadyNegative, $totalMainDelta);
                    if($toUnpublish > 0) {
                        $repository->unpublishReviews($company->id, 1, $toUnpublish);
                    }
                }
                if ($canBeNegative > 0)
                    $repository->publishReviews($company->id, 0, $canBeNegative);

            }
        }

    }

    protected function canPublishNegativeReviews($alreadyPositive, $alreadyNegative, $ratio)
    {
        /**
         * из уравнения (уже хороших) / (уже плохих + можно плохих) >= Соотношение
         */
        return max(floor(($alreadyPositive / $ratio) - $alreadyNegative), 0);
    }

    protected function canPublishPositive($alreadyPositive, $alreadyNegative, $delta) : int {
        /**
         * из уравнения (уже хороших + можно хороших) - (уже плохих) <= Дельта
         */
        return max(floor($delta + $alreadyNegative - $alreadyPositive), 0);
    }

    protected function findCountToUnpublishNegative($alreadyPositive, $alreadyNegative, $ratio) : int {
        /**
         * из уравнения (уже хороших) / (уже плохих - нужно убрать) >= Соотношения
         */
        return ceil($alreadyNegative - ($alreadyPositive/$ratio));
    }

    protected function findCountToUnpublishPositive($alreadyPositive, $alreadyNegative, $delta) : int {
        /**
         * из уравнения (уже хороших - нужно убрать) - (уже плохих) <= Дельта
         */
        return ceil($alreadyPositive - $alreadyNegative - $delta);
    }

}
