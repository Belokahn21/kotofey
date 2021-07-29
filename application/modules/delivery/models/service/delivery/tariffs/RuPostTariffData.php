<?php

namespace app\modules\delivery\models\service\delivery\tariffs;

use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\delivery\models\helper\DimensionHelper;
use app\modules\delivery\models\helper\RuPostHelper;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class RuPostTariffData implements TariffDataInterface
{
    public $index_from;
    public $index_to;
    public $mail_category = 'ORDINARY';
    public $mail_type = 'ONLINE_PARCEL';
    public $mass = 0;


    private $alias = [
        'placement_from' => 'index_from',
        'placement_to' => 'index_to',
    ];

    public function __construct(array $data)
    {
        $this->fill($data);
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'dimension') {
                $sum_volumes = 0;
                $sum_s = 0;
                foreach ($data['dimension'] as $product_id => $params) {

                    $sum_volumes += DimensionHelper::getBoxVolume($params['width'], $params['height'], $params['length']);
                    $sum_s += DimensionHelper::getBoxSquare($params['width'], $params['height'], $params['length']);


                    $this->mass += $params['weight'] * 1000;
                    $this->mass += DimensionHelper::getCardboardSummary($sum_s);

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