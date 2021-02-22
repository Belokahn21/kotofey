<?php


namespace app\modules\order\widgets\BuyerInfo;

use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\order\models\entity\Order;
use app\modules\user\models\entity\User;
use yii\base\Widget;

class BuyerInfoWidget extends Widget
{
    public $view = 'default';
    public $order;

    public function run()
    {
        if (!$this->order instanceof Order) return false;


        $orderHistory = Order::find()->where(['phone' => $this->order->phone])->andWhere(['<>', 'id', $this->order->id])->orderBy(['created_at' => SORT_DESC])->all();
        $profile = User::findByPhone($this->order->phone);
        $userBonus = UserBonusHistory::find()->where(['bonus_account_id' => $this->order->phone])->sum('count');

        return $this->render($this->view, [
            'model' => $this->order,
            'orderHistory' => $orderHistory,
            'profile' => $profile,
            'userBonus' => $userBonus
        ]);
    }
}