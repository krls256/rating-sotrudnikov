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
    protected ?array $validationData;

    public function __construct() {
        $filesystem = new Filesystem();
        $fileLoader = new FileLoader($filesystem, '');
        $translator = new Translator($fileLoader, 'ru_ru');
        $validator = new Factory($translator);
        $this->validator = $validator;
    }

    protected function prepareForValidation() {

    }

    public function validate(array $data) : Validator {
        $this->validationData = $data;
        $this->prepareForValidation();
        return $this->validator->make($this->validationData, $this->getRules(), $this->getMessages());
    }

    abstract protected function getMessages() : array;
    abstract protected function getRules() : array;
}
