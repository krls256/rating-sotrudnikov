<?php


namespace app\Modules\Publishing\Strategy;



use helperClasses\Storage;
use Illuminate\Support\Collection;

class JsonSchemaOrientedPublishingStrategy implements IPublishingStrategy
{
    use StrategyHelperTrait;

    /**
     * [
     *  {
     *      companyName: ...
     *      maxPositive: ...
     *      maxNegative: ...
     * }
     * ]
     *
     * @var Collection $jsonSchema
     */

    protected Collection $jsonSchema;
    public function __construct() {
        $storage = new Storage();
        $this->jsonSchema = collect(
            json_decode(
                $storage->getContent('/resources/config/jsonPublishingSchema.json'),
                true)
        );

    }

    public function newPublishing(): void
    {
        $this->normalizePublishing();
    }

    public function normalizePublishing(): void
    {
        $companiesRepository = $this->getCompaniesRepository();
        foreach ($companiesRepository->getCompaniesWithReviewsCounts() as $company) {
            $companyWithSchema = $this->jsonSchema->where('companyName', $company->name)->first();
            $positive = $company->reviews_published_positive_count;
            $positiveHidden = $company->reviews_not_published_positive_count;
            $negative = $company->reviews_published_negative_count;
            $negativeHidden = $company->reviews_not_published_negative_count;
            if($companyWithSchema) {
                if($companyWithSchema['maxPositive'] > $positive && $positiveHidden) {
                    $this->getReviewsRepository()->publishReviews($company->id, true, min($positiveHidden,
                        $companyWithSchema['maxPositive'] - $positive));
                } else if($companyWithSchema['maxPositive'] < $positive) {
                    $this->getReviewsRepository()->unpublishReviews($company->id, true, $positive -
                        $companyWithSchema['maxPositive']);
                }

                if($companyWithSchema['maxNegative'] > $negative && $negativeHidden) {
                    $this->getReviewsRepository()->publishReviews($company->id, false, min($negativeHidden,
                        $companyWithSchema['maxNegative'] - $negative));
                } else if ($companyWithSchema['maxNegative'] < $negative) {
                    $this->getReviewsRepository()->unpublishReviews($company->id, false, $negative -
                        $companyWithSchema['maxNegative']);
                }
            } else {

                if($positive)
                $this->getReviewsRepository()->unpublishReviews($company->id, true, $positive);
                if($negative)
                $this->getReviewsRepository()->unpublishReviews($company->id, false, $negative);
            }
        }
    }

}
