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
        $code_list = Promocode::find()->where(['quality' => Promocode::QUALITY_SIMPLE])->all();


    }

//    public function sortFreeCode(string $phone, array $code_list)
//    {
//        $result = PromocodeUser::find()->where(['phone' => $phone])->andWhere(['code' => $code_list])->all();
//
//        return ArrayHelper::getColumn($result, 'promocode') ?: false;
//    }

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