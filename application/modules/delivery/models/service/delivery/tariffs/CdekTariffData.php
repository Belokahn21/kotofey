<?php

namespace app\modules\delivery\models\service\delivery\tariffs;

use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class CdekTariffData implements TariffDataInterface
{
    public $from_location;
    public $to_location;
    public $packages = array(
        'width' => null,
        'height' => null,
        'length' => null,
        'weight' => null,
    );

    public $alias = array(
        'placement_from' => 'from_location',
        'placement_to' => 'to_location',
        'dimension' => 'packages',
    );

    public function __construct($data)
    {
        $this->fill($data);
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {

            if (ArrayHelper::keyExists($key, $this->alias)) {
                $key = ArrayHelper::getValue($this->alias, $key);
            }


//            Debug::p($key);
//            Debug::p($value);


            if (is_array($value)) {
                continue;
            }

            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }


        }


        Debug::p($this);
        Debug::p($this->from_location);
        exit();

        $this->dimension['width'] = rand(1, 10);
        $this->dimension['height'] = rand(1, 10);
        $this->dimension['length'] = rand(1, 10);
        $this->dimension['weight'] = rand(1, 10);
    }
}