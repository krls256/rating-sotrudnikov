<?php

namespace app\Modules\Publishing;

use app\Modules\Publishing\Strategy\IPublishingStrategy;
use ErrorException;

class PublishingModule {


    /**
     * не вызывать из observer, иначе будет рекурсивный вызов, если все таки нужно, то нужно написать объект
     * состояния, который будет содержать состояние
     *
     * @param int $strategyIndex
     * @throws ErrorException
     */
    public function reviewPublish(int $strategyIndex) : void {
        $strategyClass = PublishingConstants::STRATEGY_MAP[$strategyIndex] ?? null;
        if($strategyClass === null) {
            throw new ErrorException('Unknown strategy index');
        }
        /** @var IPublishingStrategy $strategy */
        $strategy = new $strategyClass();
        $strategy->newPublishing();

    }

    public function normalize(int $strategyIndex) : void {
        $strategyClass = PublishingConstants::STRATEGY_MAP[$strategyIndex] ?? null;
        if($strategyClass === null) {
            throw new ErrorException('Unknown strategy index');
        }
        /** @var IPublishingStrategy $strategy */
        $strategy = new $strategyClass();
        $strategy->normalizePublishing();
    }
}
