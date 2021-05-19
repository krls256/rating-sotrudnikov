<?php


namespace migrations\seeders;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/migrations/seeders/Seeder.php';
require_once ROOT_DIR . '/migrations/seeders/AdminSeeder.php';
require_once ROOT_DIR . '/migrations/seeders/AdviceSeeder.php';
require_once ROOT_DIR . '/migrations/seeders/SettingsSeeder.php';
require_once ROOT_DIR . '/migrations/seeders/CompanySeeder.php';
require_once ROOT_DIR . '/migrations/seeders/ReviewSeeder.php';
require_once ROOT_DIR . '/migrations/seeders/CommentSeeder.php';

use PDO;

// TODO: optimise reviews , unify code

class DumpSeeder extends Seeder
{
    private $dumpFile = ROOT_DIR . '/migrations/dump/dump.json';

    public function __construct(PDO $PDO) { parent::__construct($PDO); }


    public function run()
    {
        $readyJSON = $this->getDumpData();
        $seeding = [
            'admin' => AdminSeeder::class,
            'advice' => AdviceSeeder::class,
            'setting' => SettingsSeeder::class,
            'company' => CompanySeeder::class
        ];


        foreach ($seeding as $table => $seed) {
            $seedObj = new $seed($this->PDO, $readyJSON[$table], $table);
            $seedObj->run();
            echo $seed . '::run() - выполнена' . "\n";
        }

        $reviewSeeder = new ReviewSeeder($this->PDO, $readyJSON['review'], 'review', $readyJSON['company']);
        $reviewSeeder->run();
        echo ReviewSeeder::class . '::run() - выполнена' . "\n";

        $commentSeeder = new CommentSeeder($this->PDO, $readyJSON['comment'], 'comment',$readyJSON['review']);
        $commentSeeder->run();
        echo CommentSeeder::class . '::run() - выполнена' . "\n";
    }

    protected function getDumpData()
    {
        if (file_exists($this->dumpFile))
        {
            $dump = json_decode(file_get_contents($this->dumpFile), true);

            $readyJson = [];
            foreach ($dump as $dumpItem) {
                if (($dumpItem['type'] ?? '') === 'table') {
                    $key = $dumpItem['name'];
                    $value = $dumpItem['data'];
                    $readyJson[$key] = $value;
                }
            }
            return $readyJson;
        } else
        {
            echo $this->dumpFile . " - не обнаружен, пожалуйста, скачайте его";
            return null;
        }
    }

}