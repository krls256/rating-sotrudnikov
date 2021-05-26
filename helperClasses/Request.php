<?php


namespace helperClasses;


use Illuminate\Support\Collection;

class Request extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct(array_merge($items, $_GET, $_POST));
    }
}