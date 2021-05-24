<?php


namespace helperClasses;

class Hash
{
    private string $hashName;

    public function __construct(string $hashName = 'sha256') {
        $this->hashName = $hashName;
    }

    public function createHash($str)
    {
        return hash($this->hashName, $str);
    }
}