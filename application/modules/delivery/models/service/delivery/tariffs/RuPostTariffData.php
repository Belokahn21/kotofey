<?php

namespace app\modules\delivery\models\service\delivery\tariffs;

use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\delivery\models\helper\RuPostHelper;

class RuPostTariffData implements TariffDataInterface
{
    public $index_from;
    public $index_to;
    public $mail_category = 'ORDINARY';
    public $mail_type = 'ONLINE_PARCEL';
    public $mass;
    public $dimension = array(
        'width' => null,
        'height' => null,
        'length' => null,
    );

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
            if (isset($this->alias[$key])) $this->{$this->alias[$key]} = $value;
        }

        if ($data['products']) {
            foreach ($data['products'] as $product_id) {
                $this->mass += PropertiesHelper::getProductWeight($product_id);
            }

        }

        $this->dimension['width'] = rand(1, 10);
        $this->dimension['height'] = rand(1, 10);
        $this->dimension['length'] = rand(1, 10);

        if (!empty($this->mass)) $this->mass = RuPostHelper::getMass($this->mass);
    }
}