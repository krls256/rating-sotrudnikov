<?php


use database\Database;

function getDatabase() : Database {
    return Database::getInstance();
}