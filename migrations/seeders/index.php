<?php


use migrations\seeders\DumpSeeder;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/public/class/Mysql.php';
require_once ROOT_DIR . '/migrations/seeders/DumpSeeder.php';


if (isset($argv)) // запуск из командной строки
{
    $seederObj = new DumpSeeder($PDO);
    $seederObj->run();
} else {
    header('Location: /404');
}