<?php

namespace app\modules\statistic\widgets;


use app\modules\logger\models\entity\Logger;
use app\modules\order\models\entity\Order;
use app\modules\search\models\entity\SearchQuery;
use yii\base\Widget;

class StatisticWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $searches = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->all();
        $lastSearch = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        $lastlogs = Logger::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        $logs = Logger::find()->orderBy(['created_at' => SORT_DESC])->limit(500)->all();


        $ordersNow = Order::find()->leftJoin('order_date', 'order.id=order_date.order_id')
            ->where(['order_date.date' => \Yii::$app->request->get('deliveryDate') ? \Yii::$app->request->get('deliveryDate') : date('d.m.Y')])
            ->andWhere(['is_close' => false])
            ->andWhere(['is_cancel' => false]);
        $ordersNow = $ordersNow->all();


        return $this->render($this->view, [
            'searches' => $searches,
            'lastSearch' => $lastSearch,
            'logs' => $logs,
            'lastlogs' => $lastlogs,
            'ordersNow' => $ordersNow,
        ]);
    }
}