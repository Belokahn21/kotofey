<?php


namespace app\modules\bonus\models\service;


use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\bonus\models\helper\UserBonusHistoryHelper;
use app\modules\order\models\entity\Order;

class BonusService
{
    public function __construct(Order $order)
    {
        // Проверить что модуль включен
        if ($module = \Yii::$app->getModule('bonus')) {
            if (!$module->getEnable()) {
                return false;
            }
        }

        // Проверить что нет промокода. Запрещено начислять бонусы при наличии промокода
        if ($order->promocode || !$order->is_paid) return false;


        // Проверить что нет предыдущих записей о начислениях
        $oldHistoryElement = UserBonusHistory::findOneByOrder($order);
        if (!$oldHistoryElement->is_active) UserBonusHistoryHelper::activateHistoryElement($oldHistoryElement); // todo: возможно убрать, зачем? проверить нужно что при создании заказа нет записей о бонусах. они появятся при закрытии тога эта запись позволит повторно не начислять бонусы при изменении заказа
        if ($oldHistoryElement->is_active) return false;

        // Добавить запись в историю бонусов для клиента
        BonusHelper::addHistory($order, BonusHelper::calcFinalResultBonus($order), "Зачисление за заказ #" . $order->id, true);
    }
}