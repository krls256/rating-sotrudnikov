<?php

try
{
    $PDO = $db->getPDO();
} catch (PDOException $e)
{
    die('Подключение не удалось: ' . $e->getMessage());
}
