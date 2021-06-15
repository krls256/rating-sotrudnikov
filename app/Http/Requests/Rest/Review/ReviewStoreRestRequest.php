<?php


namespace app\Http\Requests\Rest\Review;


use app\Http\Requests\CoreRequest;
use app\Repositories\Base\BaseReviewsRepository;
use app\Rules\ExistsRule;
use app\Rules\UniqueReviewHashRule;

class ReviewStoreRestRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [
            'reviewer_name.string' => 'Поле "Имя пользователя" должны быть строкой',
            'reviewer_name.nullable' => 'Поле "Имя пользователя" может быть не задано',
            'reviewer_name.max' => 'Поле "Имя пользователя" слишком длинное',
            'reviewer_position.string' => 'Поле "позиция" должны быть строкой',
            'reviewer_position.nullable' => 'Поле "позиция" может быть не задано',
            'reviewer_position.max' => 'Поле "позиция" слишком длинное',
            'review_date.date' => 'Некорректный формат даты',
            'review_date.required' => 'Дата - обязательное поле',
            'review_pluses.string' => 'Плюсы должны быть строкой',
            'review_pluses.nullable' => 'Плюсы могут быть не заданы',
            'review_minuses.string' => 'Минусы должны быть строкой',
            'review_minuses.nullable' => 'Минусы могут быть не заданы',
            'is_positive.boolean' => 'Поле "Положительный" - должно иметь булиновое значение',
            'is_positive.required' => 'Поле "Положительный" - обязательно',
            'is_published.boolean' => 'Поле "Опубликован" - должно иметь булиновое значение',
            'is_published.required' => 'Поле "Опубликован" - обязательное',
            'company_id.required' => 'Компания - обязательное поле'
        ];
    }

    protected function getRules(): array
    {
        $reviewRepo = new BaseReviewsRepository();
        $reviewsWithHash = $reviewRepo->getReviewsHashes();

        return [
            'full_review' => [new UniqueReviewHashRule($reviewsWithHash)],
            'reviewer_name' => 'string|nullable|max:100',
            'reviewer_position' => 'string|nullable|max:100',
            'review_date' => 'date|required',
            'review_pluses' => 'string|nullable',
            'review_minuses' => 'string|nullable',
            'is_positive' => 'boolean|required',
            'is_published' => 'boolean|required',
            'company_id' => ['required', new ExistsRule('company', 'id')]
        ];
    }

    protected function prepareForValidation()
    {
        $this->validationData = array_merge(
            $this->validationData,
            ['full_review' => [
                'review_pluses' => $this->validationData['review_pluses'] ?? '',
                'review_minuses' => $this->validationData['review_minuses'] ?? ''
            ]]
        );
    }
}
