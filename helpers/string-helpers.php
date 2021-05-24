<?php

use helperClasses\Hash;

function getHash(string $content, string $algo = 'sha256') {
    $hashClass = new Hash($algo);

    return $hashClass->createHash($content);
}