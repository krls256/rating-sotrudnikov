<?php


namespace app\Rules;


use app\Models\Review;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

class UniqueReviewHashRule implements Rule
{
    protected ?string $message;
    protected Collection $reviewHashes;

    public function __construct(Collection $reviewHashes, string $message = null) {
        $this->message = $message;
        $this->reviewHashes = $reviewHashes;
    }

    public function passes($attribute, $value)
    {
        $id = $value['id'] ?? null;
        $pluses = $value['review_pluses'] ?? '';
        $minuses = $value['review_minuses'] ?? '';
        $hash = Review::getHash($pluses, $minuses);
        if($id) {
            $count = $this->reviewHashes->where('review_hash', $hash)->where('id', '!=', $id)->count();
        } else {
            $count = $this->reviewHashes->where('review_hash', $hash)->count();
        }

        return $count === 0;
    }

    public function message()
    {
        return $this->message ?? 'Такой отзыв уже существует.';
    }

}
