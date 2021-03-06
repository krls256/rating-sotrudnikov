<?php

use migrations\migrations\MigrationManager;
use migrations\seeders\DumpSeeder;

require_once __DIR__ . '/../config.php';
require_once ROOT_DIR . '/public/class/Mysql.php';

// TODO: rewrite on illuminate\database migrations

if (isset($argv)) {
    array_shift($argv);

    $commands = [
        'refresh',
        'migrate',
        'seed',
    ];

    if(in_array($commands[0], $argv)) {
        $migrationManager = new MigrationManager($PDO);
        $seederObj = new DumpSeeder($PDO, $db->getDB());
        $migrationManager->down();
        $migrationManager->up();
        $seederObj->run();
    } else if(in_array($commands[1], $argv)) {
        $migrationManager = new MigrationManager($PDO);
        $seederObj = new DumpSeeder($PDO, $db->getDB());
        $migrationManager->up();
        $seederObj->run();
    } else if(in_array($commands[2], $argv)) {
        $seederObj = new DumpSeeder($PDO, $db->getDB());
        $seederObj->run();
    }

} else {
    header('Location: /404');
}
