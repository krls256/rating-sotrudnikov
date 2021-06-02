<?php

namespace app\Modules\Publishing;

use app\Modules\Publishing\Strategy\IPublishingStrategy;
use ErrorException;

class PublishingModule
{

    protected PublishingState $state;

    public function __construct()
    {
        $this->state = PublishingState::getInstance();
    }

    /**
     *
     * @param int $strategyIndex
     * @throws ErrorException
     */
    public function reviewPublish(int $strategyIndex): void
    {
        if (!$this->state->isWorking())
        {
            $this->state->setIsWorking(true);
            $strategyClass = PublishingConstants::STRATEGY_MAP[$strategyIndex] ?? null;
            if ($strategyClass === null)
            {
                throw new ErrorException('Unknown strategy index');
            }
            /** @var IPublishingStrategy $strategy */
            $strategy = new $strategyClass();
            $strategy->newPublishing();
        }
    }

    public function normalize(int $strategyIndex): void
    {
        if (!$this->state->isWorking())
        {
            $this->state->setIsWorking(true);
            $strategyClass = PublishingConstants::STRATEGY_MAP[$strategyIndex] ?? null;
            if ($strategyClass === null)
            {
                throw new ErrorException('Unknown strategy index');
            }
            /** @var IPublishingStrategy $strategy */
            $strategy = new $strategyClass();
            $strategy->normalizePublishing();
        }
    }
}
