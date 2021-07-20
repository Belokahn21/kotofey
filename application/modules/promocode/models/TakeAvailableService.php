<?php

namespace app\modules\promocode\models;

use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\entity\PromocodeUser;

class TakeAvailableService
{
    private $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function getPromo()
    {
        $code = Promocode::findOne(['code' => rand()]);

        if ($this->isFree($this->phone, $code)) {
            $code = $this->randomSaleCode();
        }

        if (!$code instanceof Promocode) throw new \Exception('Ошибка');

        return $code->code;
    }

    public function isFree(string $phone, Promocode $code)
    {
        return PromocodeUser::find()->where(['phone' => $phone, 'code' => $code->code]) ? true : false;
    }

    public function randomSaleCode()
    {
        $pc = new Promocode();
        $pc->code = \Yii::$app->security->generateRandomString(5);
        $pc->discount = 5;
        $pc->infinity = 1;
        $pc->count = 0;

        if (!$pc->validate() || !$pc->save()) return false;

        return $pc;
    }
}