<?php

namespace app\modules\delivery\models\service\delivery\tariffs;

class CdekTariffData implements TariffDataInterface
{
    public $from_location;
    public $to_location;
    public $dimension = array(
        'width' => null,
        'height' => null,
        'length' => null,
        'weight' => null,
    );

    public function __construct($data)
    {
        $this->fill($data);
    }

    public function fill(array $data)
    {
        $this->from_location = $data['placement_from'];
        $this->to_location = $data['placement_to'];

        $this->dimension['width'] = rand(1, 10);
        $this->dimension['height'] = rand(1, 10);
        $this->dimension['length'] = rand(1, 10);
        $this->dimension['weight'] = rand(1, 10);
    }
}