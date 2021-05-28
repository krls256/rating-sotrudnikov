<?php


namespace app\Rules;


use Illuminate\Contracts\Validation\Rule;

class InArrayRule implements Rule
{

    protected array $array;

    public function __construct(array $array) {
        $this->array = $array;
    }

    public function passes($attribute, $value)
    {
        return in_array($value, $this->array);
    }

    public function message()
    {
        return "Значение :attribute не входит в перечень допустимых значений";
    }
}