<?php


namespace app\Http\Requests;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

abstract class CoreRequest
{
    protected Factory $validator;

    public function __construct() {
        $filesystem = new Filesystem();
        $fileLoader = new FileLoader($filesystem, '');
        $translator = new Translator($fileLoader, 'ru_ru');
        $validator = new Factory($translator);
        $this->validator = $validator;
    }

    public function validate(array $data) : Validator {
        return $this->validator->make($data, $this->getRules(), $this->getMessages());
    }

    abstract protected function getMessages() : array;
    abstract protected function getRules() : array;
}