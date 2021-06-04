<?php


namespace migrations\migrations;

use PDO;

class MigrationManager
{
    private $PDO;
    private $migrations = [
        AdminMigration::class,
        AdviceMigration::class,
        CompanyMigration::class,
        ReviewMigration::class,
        CommentMigration::class,
        SettingsMigration::class,
        UserRequestMigration::class
    ];

    public function __construct(PDO $PDO) {
        $this->PDO = $PDO;
    }

    public function up()
    {
        foreach ($this->migrations as $migration) {
            $migrationObj =  new $migration($this->PDO);
            $migrationObj->up();
            echo $migration . '::up() - выполнена' . "\n";
        }
    }

    public function down()
    {
        $migrations = array_reverse($this->migrations);
        foreach ($migrations as $migration)
        {
            $migrationObj = new $migration($this->PDO);
            $migrationObj->down();
            echo $migration . '::down() - выполнена' . "\n";
        }
    }
}
