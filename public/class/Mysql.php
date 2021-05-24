<?php

//$host = 'localhost';
//$user = 'ca88265373_os';
//$pass = "Qwqw123!";
//$db   = 'ca88265373_os';
//$charset = 'utf8';

//
//include_once "credentials.php";
//$host = $dbCredentials['host'];
//$user = $dbCredentials['user'];
//$pass = $dbCredentials['pass'];
//$db = $dbCredentials['db'];
//$charset = $dbCredentials['charset'];
//
//$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//$opt = [
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//    PDO::ATTR_EMULATE_PREPARES => true,
//    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
//];

try
{
    $PDO = $db->getPDO();
} catch (PDOException $e)
{
    die('Подключение не удалось: ' . $e->getMessage());
}