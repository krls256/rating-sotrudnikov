<?php


namespace app\Modules\Publishing;


use patterns\Singleton;

class PublishingState extends Singleton
{
    private bool $is_working;

    protected function __construct() {
        parent::__construct();
        $this->is_working = false;
    }

    /**
     * @return bool
     */
    public function isWorking(): bool
    {
        return $this->is_working;
    }

    /**
     * @param bool $is_working
     */
    public function setIsWorking(bool $is_working): void
    {
        $this->is_working = $is_working;
    }


}
