<?php


namespace app\Models\Aggregates;


use Illuminate\Support\Collection;
use patterns\Singleton;

class ReviewSource extends Singleton
{
    protected Collection $types;
    protected Collection $sites;
    protected Collection $russianNames;

    protected function __construct() {
        parent::__construct();

        $this->types = collect([
            'neotrude', 'otrude', 'otzyvy-rabota', 'retwork', 'sros', 'antijob'
        ]);
        $this->sites = collect([
            'neotrude' => 'https://neorabote.net/',
            'otrude' => 'https://otrude.net/',
            'otzyvy-rabota' => 'https://otzyvy-rabota.ru/',
            'retwork' => 'https://retwork.com/',
            'sros' => 'https://studiya-remontov-otzyvy-sotrudnikov.ru/',
            'antijob' => 'https://antijob.name/'
        ]);

        $this->russianNames = collect([
            'neotrude' => 'Не о работе',
            'otrude' => 'О работе',
            'otzyvy-rabota' => 'Отзывы Работа',
            'retwork' => 'Retwotk',
            'sros' => 'СР Отзывы сотрудников',
            'antijob' => 'Antijob'
        ]);
    }

    public function sites() : array {
        return $this->sites->toArray();
    }

    public function all() : array  {
        return $this->types->toArray();
    }

    public function russianName($index) {
        return $this->russianNames->get($index);
    }
}