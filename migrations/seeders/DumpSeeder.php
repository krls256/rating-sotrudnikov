<?php


namespace migrations\seeders;

require_once __DIR__ . '/../../config.php';

use app\Models\Advice;
use app\Models\Comment;
use app\Models\Company;
use app\Models\Review;
use app\Models\Setting;
use app\Models\User;
use PDO;

// TODO: optimise reviews , unify code

class DumpSeeder extends Seeder
{
    private $dumpFile = ROOT_DIR . '/migrations/dump/dump.json';

    public function __construct(PDO $PDO, $db) { parent::__construct($PDO, $db); }


    public function run()
    {
        $readyJSON = $this->getDumpData();
        $seeding = [
            'admin' => [AdminSeeder::class, User::class],
            'advice' => [AdviceSeeder::class, Advice::class],
            'setting' => [SettingsSeeder::class, Setting::class],
            'company' => [CompanySeeder::class, Company::class]
        ];


        foreach ($seeding as $table => $arr) {
            [$seed, $model] = $arr;
            $seedObj = new $seed($this->PDO, $this->db, $readyJSON[$table], $model);
            $seedObj->run();
            echo $seed . '::run() - выполнена' . "\n";
        }

        $reviewSeeder = new ReviewSeeder($this->PDO, $this->db, $readyJSON['review'], Review::class, $readyJSON['company']);
        $reviewSeeder->run();
        echo ReviewSeeder::class . '::run() - выполнена' . "\n";

        $commentSeeder = new CommentSeeder($this->PDO, $this->db, $readyJSON['comment'], Comment::class,$readyJSON['review']);
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
