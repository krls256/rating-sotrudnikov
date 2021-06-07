<?php

use helperClasses\Request;

function include_view($path, $data = []) {
    extract($data);
    $request = new Request();
    include ROOT_DIR . '/resources/views/' . $path;
}
