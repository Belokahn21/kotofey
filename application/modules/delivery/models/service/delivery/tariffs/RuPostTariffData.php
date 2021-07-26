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

    private $assoc = [
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
            if (isset($this->assoc[$key])) $this->{$this->assoc[$key]} = $value;
        }

        if ($data['products']) {
            foreach ($data['products'] as $product_id) {
                $this->mass += PropertiesHelper::getProductWeight($product_id);
            }

        }

        $this->dimension['width'] = rand(1, 10);
        $this->dimension['height'] = rand(1, 10);
        $this->dimension['length'] = rand(1, 10);

        /*
         * {
	"completeness-checking": true,
	"courier": true,
	"declared-value": 0,
	"dimension": {
		"height": 0,
		"length": 0,
		"width": 0
	},
	"entries-type": "GIFT",
	"fragile": true,
	"index-from": "string",
	"index-to": "string",
	"mail-category": "SIMPLE",
	"mail-direct": 0,
	"mail-type": "UNDEFINED",
	"mass": 0,
	"notice-payment-method": "CASHLESS",
	"payment-method": "CASHLESS",
	"sms-notice-recipient": 0,
	"transport-type": "SURFACE",
	"with-order-of-notice": true,
	"with-simple-notice": true
}
        */


        if (!empty($this->mass)) $this->mass = RuPostHelper::getMass($this->mass);
    }
}