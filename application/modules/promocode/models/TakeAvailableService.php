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

        $check = $this->isFreePack($this->phone, $code_list);

        if (!$this->isFreePack($this->phone, $code_list)) {
            $code = $this->randomSaleCode();
        }

        if ($code_list) {
            exit();
        }
        if (!$code instanceof Promocode) throw new \Exception('Ошибка');

        return $code->code;
    }

    public function isFreePack(string $phone, array $code_list)
    {
        $q = PromocodeUser::find()->where(['phone' => $phone])->andWhere(['code' => ArrayHelper::getColumn($code_list, 'code')])->all();
        return $q ? false : true;
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