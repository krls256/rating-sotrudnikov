<?php

namespace app\Modules\Publishing\Strategy;

use app\Modules\Publishing\Types\PublishingContainer;

interface IPublishingStrategy {
    public function newPublishing() : void;

    public function normalizePublishing() : void;
}
