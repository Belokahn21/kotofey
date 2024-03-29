<?php

namespace app\modules\site\widgets\AdminPanel;

use app\modules\order\models\entity\Order;
use app\modules\user\models\entity\User;
use app\modules\news\widgets\last_news\LastNewsWidget;

class AdminPanel extends \yii\base\Widget
{
    public $time_cache;

    public function run()
    {
        $access = false;
        $roles = ['Developer', 'Administrator', 'Content', 'SaleManager'];

        foreach ($roles as $role) {
            if (User::isRole($role)) {
                $access = true;
                break;
            }
        }

        if (!$access) return false;

        $cache = \Yii::$app->cache;
        $key = LastNewsWidget::className();
        $this->time_cache = 3600 * 60 * 24;

        $count_orders = $cache->getOrSet($key . '-count_orders', function () {
            return Order::find()->count();
        }, $this->time_cache);

        return $this->render('default', [
            'count_orders' => $count_orders
        ]);
    }
}