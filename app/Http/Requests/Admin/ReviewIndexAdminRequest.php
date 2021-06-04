<?php


namespace app\Http\Requests\Admin;


use app\Http\Requests\CoreRequest;
use app\Models\Review;
use app\Rules\ExistsRule;
use app\Rules\InArrayRule;

class ReviewIndexAdminRequest extends CoreRequest
{
    protected function getMessages(): array {   return [    ];  }

    protected function getRules(): array
    {
        return [
            'company_id' => ['nullable', new ExistsRule('company', 'id')],
            'is_positive' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'is_moderated' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'review_source' => ['nullable', new InArrayRule(Review::source()->all())],
            'sort_by' => ['nullable', new InArrayRule(['asc', 'desc'])]
        ];
    }

}
