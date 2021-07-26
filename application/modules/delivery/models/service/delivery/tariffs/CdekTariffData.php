<?php

namespace app\modules\delivery\models\service\delivery\tariffs;

class CdekTariffData implements TariffDataInterface
{
    public $from_location;
    public $to_location;
    public $packages;
    public $weight;

    public function __construct($data)
    {
        $this->fill($data);
    }

    public function fill(array $data)
    {
    }
}