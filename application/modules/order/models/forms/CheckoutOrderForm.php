<?php

namespace app\modules\order\models\forms;

use app\modules\order\models\entity\Order;
use app\modules\site\models\tools\Debug;

class CheckoutOrderForm extends Order
{
    public $address;

    public static function tableName()
    {
        return Order::tableName();
    }

    public function rules()
    {
//        $parent = parent::rules();
//
//        $parent[] = ['address', 'required', 'on'];
//        $parent[] = ['address', 'string'];
//
//
//        Debug::p($parent);
//        exit();
//
//        return $parent;


        return [
            ['address', 'required', 'on' => self::SCENARIO_CLIENT_BUY]
        ];
    }
}