<?php

function include_view($path, $data = []) {
    extract($data);
    include ROOT_DIR . '/resources/views/' . $path;
}
