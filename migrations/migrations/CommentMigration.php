<?php


namespace migrations\migrations;

use PDO;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/migrations/migrations/Migration.php';


class CommentMigration extends Migration
{

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'comment');
    }

    public function up()
    {
        $table = $this->table;
        $column = ['id INT AUTO_INCREMENT PRIMARY KEY', 'fio VARCHAR(191)', 'text TEXT', 'review_id INT',
            'is_moderated INT(1) DEFAULT 0', 'comment_date DATETIME',
            'FOREIGN KEY (review_id) REFERENCES review(id) ON DELETE CASCADE ON UPDATE CASCADE'];
        $column = implode(', ', $column);
        $this->PDO->exec("CREATE TABLE IF NOT EXISTS $table ($column) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    }
}
