<?php

namespace app\modules\marketplace\models\entity;

class OzonAttributes
{
    private $complex_id;
    private $id;
    private $values;

    public function load(int $complex_id, int $id, OzonAttributeValue $values)
    {
        $this->id = $id;
        $this->complex_id = $complex_id;
        $this->values = $values;
    }
}