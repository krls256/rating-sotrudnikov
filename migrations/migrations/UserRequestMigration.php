<?php

namespace migrations\migrations;

use PDO;

class UserRequestMigration extends Migration
{
    public function __construct(PDO $PDO) {
        parent::__construct($PDO, 'user_requests');
    }

    public function up()
    {
        $table = $this->table;
        $column = ['id INT AUTO_INCREMENT PRIMARY KEY', 'user_name VARCHAR(191)', 'user_phone VARCHAR(20)', 'company_id INT', 'is_watched INT(1) DEFAULT 0',
            'FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE ON UPDATE CASCADE'];
        $column = implode(', ', $column);
        $this->PDO->exec("CREATE TABLE IF NOT EXISTS $table ($column) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

}
