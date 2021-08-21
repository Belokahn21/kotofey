<?php

namespace app\modules\bonus\models\helper;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\tools\Debug;

class BonusHelper
{
    public static function addOrderBonus(Order $order, $active = true)
    {
        if (self::isBonused($order) or !empty($order->promocode)) return false;
        return self::addHistory($order, self::calcFinalResultBonus($order), "Зачисление за заказ #" . $order->id, $active);
    }

    public static function applyOrderBonus(Order $order)
    {
        if ($module = \Yii::$app->getModule('bonus')) {
            $elementHistory = UserBonusHistory::findOneByOrder($order);
            if ($elementHistory) {
                $elementHistory->is_active = true;
                return $elementHistory->validate() && $elementHistory->update();
            }

            return self::addOrderBonus($order);
        }
    }

    public static function calcFinalResultBonus(Order $order)
    {
        return round(OrderHelper::orderSummary($order) * (UserBonus::PERCENT_AFTER_SALE / 100));
    }

    public static function isBonused(Order $order)
    {
        return UserBonusHistory::findOne(['order_id' => $order->id, 'bonus_account_id' => $order->phone, 'is_active' => true]) instanceof UserBonusHistory;
    }

    public static function getUserBonus($phone)
    {
        return UserBonusHistory::find()->where(['bonus_account_id' => $phone, 'is_active' => true])->sum('count');
    }

    public static function addHistory(Order $order, $count, $reason, $active = true)
    {
        $obj = new UserBonusHistory();
        $obj->reason = $reason;
        $obj->count = $count;
        $obj->order_id = $order->id;
        $obj->bonus_account_id = $order->phone;
        $obj->is_active = $active;

        return $obj->validate() && $obj->save();
    }

    public static function createBonusAccount($phone)
    {
        $obj = new UserBonusHistory();
        $obj->count = 0;
        $obj->is_active = 1;
        $obj->bonus_account_id = $phone;
        $obj->reason = "Аккаунт создан";
        return $obj->validate() && $obj->save();
    }

    public static function calcProductBonus(Product $model)
    {
        return round(($model->getPrice() * UserBonus::PERCENT_AFTER_SALE) / 100);
    }
}