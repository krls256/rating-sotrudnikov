<?php


namespace app\Rules;


use Illuminate\Contracts\Validation\Rule;

class NotPassRule implements Rule
{
    protected string $message;

    public function __construct($message) {
        $this->message = $message;
    }

    public function passes($attribute, $value)
    {
        return false;
    }

    public function message()
    {
        return $this->message;
    }

}
