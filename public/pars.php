<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    include 'class/parser.php';

    $pars = new Neorabote([
        'http://mDFh7iWH:942GSphc@213.226.113.155:51205',
        'http://mDFh7iWH:942GSphc@45.93.80.208:52746',
        'http://mDFh7iWH:942GSphc@45.91.239.190:52339',
        'http://mDFh7iWH:942GSphc@45.95.31.27:58111',
        'http://mDFh7iWH:942GSphc@94.154.188.175:63526'
    ]);

    echo $pars->collect(125957);
?>