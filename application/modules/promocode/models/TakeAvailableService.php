<?php

namespace app\modules\promocode\models;

use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\entity\PromocodeUser;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class TakeAvailableService
{
    private $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function getPromo()
    {
        $code_list = ArrayHelper::getColumn(Promocode::find()->where(['quality' => Promocode::QUALITY_SIMPLE])->all(), 'code');

        if (!$code = $this->isFreePack($this->phone, $code_list)) {
            $code = $this->randomSaleCode();
        }

        if (!$code instanceof Promocode) throw new \Exception('Ошибка');

        return $code->code;
    }

    public function isFreePack(string $phone, array $code)
    {
        return PromocodeUser::find()->where(['phone' => $phone])->andWhere(['in', 'code', $code])->all()[0] ?: false;
    }

    public function isFree(string $phone, Promocode $code)
    {
        return PromocodeUser::findOne(['phone' => $phone, 'code' => $code->code]) ?: false;
    }

    public function randomSaleCode()
    {
        $pc = new Promocode();
        $pc->code = \Yii::$app->security->generateRandomString(5);
        $pc->discount = 5;
        $pc->infinity = 1;
        $pc->count = 0;
        $pc->quality = Promocode::QUALITY_SIMPLE;

        if (!$pc->validate() || !$pc->save()) return false;

        return $pc;
    }
}