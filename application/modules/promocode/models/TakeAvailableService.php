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
        $used_list = PromocodeUser::find()->where(['phone' => $this->phone])->all();
        $code_list = Promocode::find()->where(['quality' => Promocode::QUALITY_SIMPLE])->andWhere(['not in', 'code', ArrayHelper::getColumn($used_list, 'code')])->all();

        if (!$code_list) {
            $code = $this->randomSaleCode();
        } else {
            $code = $code_list[0];
        }

        return $code->code;
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