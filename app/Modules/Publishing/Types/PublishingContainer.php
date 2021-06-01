<?php

namespace app\Modules\Publishing\Types;

class PublishingContainer {
    protected array $to_publish;
    protected array $to_unpublish;

    public function __construct($to_publish, $to_unpublish) {
        $this->to_publish = $to_publish;
        $this->to_unpublish = $to_unpublish;
    }

    public function getPublish() {
        return $this->to_publish;
    }

    public function getUnpublish() {
        return $this->to_unpublish;
    }
}
