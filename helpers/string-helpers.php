<?php

use helperClasses\Hash;

function getHash(string $content, string $algo = 'sha256') {
    $hashClass = new Hash($algo);

    return $hashClass->createHash($content);
}

function crop($string, $long) {
    $addEllipsis = mb_strlen($string) > $long;
    $text = strip_tags($string);
    $text = mb_substr($text, 0, $long);
    $text = rtrim($text, "!,.-");
    if(strpos($text, ' '))
        $text = substr($text, 0, strrpos($text, ' '));

    return $addEllipsis ? $text . '...': $text;
}
