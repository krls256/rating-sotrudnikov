<?php

namespace app\Modules\Publishing;

use app\Modules\Publishing\Strategy\DeltaOrientedPublishingStrategy;
use app\Modules\Publishing\Strategy\JsonSchemaOrientedPublishingStrategy;

class PublishingConstants
{
    /** Приемущество главной компании над остальными */
    public const MAX_PERMISSIBLE_DELTA = 25;
    public const MAX_PERMISSIBLE_DELTA_IN_RATIO = 5; // (percents)

    public const NECESSARY_POSITIVE_TO_NEGATIVE_RATIO_FOR_MAIN_COMPANY = 9;

    public const SPECIAL_COMPANY_NAME = 'Студия Ремонтов';

    public const DELTA_ORIENTED_INDEX = 0;
    public const JSON_SCHEMA_ORIENTED_INDEX = 1;

    public const STRATEGY_MAP = [
        DeltaOrientedPublishingStrategy::class,
        JsonSchemaOrientedPublishingStrategy::class
    ];
}
