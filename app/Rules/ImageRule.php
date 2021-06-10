<?php


namespace app\Rules;


use Illuminate\Contracts\Validation\Rule;

class ImageRule implements Rule
{
    protected $key = 'image';

    public function passes($attribute, $value)
    {
        return strpos($value['type'], $this->key) !== false;
    }

    public function message()
    {
        return 'Поле :attribute должно быть картинкой';
    }

}
