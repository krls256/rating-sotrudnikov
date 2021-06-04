<?php


namespace app\Rules;


use Illuminate\Contracts\Validation\Rule;

class NumberMaskRule implements Rule
{
    protected string $mask;

    public function __construct(string $mask) {
        $this->mask = $mask;
    }

    public function passes($attribute, $value)
    {
        $pass = true;
        if(strlen($value) !== strlen($this->mask)) {
            return false;
        }

        for ($i = 0; $i < strlen($value); $i++) {
            $v = $value[$i];
            $m = $this->mask[$i];
            if($m === '0') {
                if(!is_numeric($v))
                    $pass = false;
            } elseif($m !== $v) {
                $pass = false;
            }
        }

        return $pass;
    }

    public function message()
    {
        return ":attribute не соответствует маске";
    }

}
