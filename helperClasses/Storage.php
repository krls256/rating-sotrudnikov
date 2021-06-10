<?php


namespace helperClasses;


class Storage
{
    protected string $working_dir;
    protected string $root = ROOT_DIR;

    public function __construct($working_dir = '/') {
        if(strpos($working_dir, $this->root) !== false) {
            $this->working_dir = $working_dir;

        } else {
            $this->working_dir = realpath(ROOT_DIR . '/' . $working_dir . '/');
        }
    }

    public function storeFileFromHTTP($file, $name) : array {

        $preExtension = explode('/', $file["type"]);
        $extension = $preExtension[count($preExtension) - 1];
        $finalName =  $name . '.' . $extension;

        $res = move_uploaded_file($file['tmp_name'], $this->working_dir . '/' . $finalName);

        return ['status' => $res, 'path' => $finalName];
    }
}
