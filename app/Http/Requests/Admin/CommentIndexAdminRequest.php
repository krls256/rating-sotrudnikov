<?php


namespace app\Http\Requests\Admin;

use app\Http\Requests\CoreRequest;
use app\Models\Review;
use app\Rules\ExistsRule;
use app\Rules\InArrayRule;

class CommentIndexAdminRequest extends CoreRequest
{
    protected function getMessages(): array {   return [    ];  }

    protected function getRules(): array
    {
        return [
            'is_moderated' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'sort_by' => ['nullable', new InArrayRule(['asc', 'desc'])]
        ];
    }

}
