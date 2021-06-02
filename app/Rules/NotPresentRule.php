<?php


namespace app\Rules;


use Illuminate\Contracts\Validation\Rule;

class NotPresentRule implements Rule
{
    public function passes($attribute, $value)
    {
        /** если присутствует поле мы попадем в этот метод */
        return false;
    }

    public function message()
    {
        return 'Поле :attribute не должно быть задано';
    }

}
