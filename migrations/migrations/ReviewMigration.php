<?php


namespace migrations\migrations;

use PDO;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/migrations/migrations/Migration.php';


class ReviewMigration extends Migration
{
    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'review');
    }

    public function up()
    {
        $table = $this->table;
        $column = ['id INT AUTO_INCREMENT PRIMARY KEY', 'reviewer_name VARCHAR(100) NULL', 'reviewer_position VARCHAR(100) NULL',
            'is_positive int(1) NULL', 'is_published int(1) DEFAULT 0', 'review_pluses TEXT', 'review_minuses TEXT',
            'review_date date', 'review_source VARCHAR(20)', 'review_hash VARCHAR(256)','company_id INT',
            'FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE ON UPDATE CASCADE'];
        $column = implode(', ', $column);
        $this->PDO->exec("CREATE TABLE IF NOT EXISTS $table ($column) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    }
}