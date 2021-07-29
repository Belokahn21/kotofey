<?php

namespace app\modules\delivery\models\service\delivery\tariffs;

use app\modules\delivery\models\helper\DimensionHelper;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class CdekTariffData implements TariffDataInterface
{
    public $from_location;
    public $to_location;
    public $packages = array();

    public $alias = array(
        'placement_from' => 'from_location',
        'placement_to' => 'to_location',
    );

    public function __construct($data)
    {
        $this->fill($data);
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'dimension') {
                $sum_volumes = 0;
                $sum_s = 0;
                foreach ($data['dimension'] as $product_id => $data) {
                    $this->packages[] = [
                        'width' => $data['width'],
                        'height' => $data['height'],
                        'length' => $data['length'],
                        'weight' => $data['weight'] * 1000,
                    ];

                    $sum_volumes += DimensionHelper::getBoxVolume($data['width'], $data['height'], $data['length']);
                    $sum_s += DimensionHelper::getBoxSquare($data['width'], $data['height'], $data['length']);

                    continue;
                }

            }

            if (ArrayHelper::keyExists($key, $this->alias)) {
                $key = ArrayHelper::getValue($this->alias, $key);
            }

            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }

            if (is_array($value)) {
                $this->fill($value);
            }
        }
    }
}