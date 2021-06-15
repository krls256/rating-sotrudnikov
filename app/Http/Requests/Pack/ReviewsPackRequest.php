<?php


namespace app\Http\Requests\Pack;


use app\Http\Requests\CoreRequest;
use app\Models\Review;
use app\Repositories\Base\BaseReviewsRepository;
use app\Rules\ExistsRule;
use app\Rules\InArrayRule;
use app\Rules\UniqueReviewHashRule;

class ReviewsPackRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'array' => "Поле :attribute должно быть массивом.",
            'required' => "Поле :attribute обязательное.",
        ];
    }

    protected function getRules(): array
    {
        $reviewRepo = new BaseReviewsRepository();
        $reviewsWithHash = $reviewRepo->getReviewsHashes();


        return [
            'reviews' => 'required|array',
            'reviews.*' => ['array', new UniqueReviewHashRule($reviewsWithHash)],
            'reviews.*.reviewer_name' => 'string|nullable|max:191',
            'reviews.*.reviewer_position' => 'string|nullable|max:191',
            'reviews.*.is_positive' => 'required|boolean',
            'reviews.*.review_pluses' => 'string|nullable|max:16000000',
            'reviews.*.review_minuses' => 'string|nullable|max:16000000',
            'reviews.*.review_date' => 'required|date',
            'reviews.*.company_name' => ['string','max:191','required', new ExistsRule('company', 'name')],
            'reviews.*.review_source' => ['string', 'max:191', 'required', new InArrayRule(Review::source()->all())],
        ];
    }

}
