<?php

namespace migrations\migrations;

use PDO;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/migrations/migrations/Migration.php';

class AdviceMigration extends Migration
{

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'advice');
    }

    public function up()
    {
        $table = $this->table;
        $column = ['id INT AUTO_INCREMENT PRIMARY KEY', 'text TEXT'];
        $column = implode(', ', $column);
        $this->PDO->exec("CREATE TABLE IF NOT EXISTS $table ($column) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    }

}