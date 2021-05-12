<?php

namespace app\modules\statistic\widgets;


use app\modules\logger\models\entity\Logger;
use app\modules\order\models\entity\Order;
use app\modules\reviews\models\entity\Reviews;
use app\modules\search\models\entity\SearchQuery;
use yii\base\Widget;
use yii\caching\DbDependency;

class StatisticWidget extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 27 * 1;

    public function run()
    {
        $lastSearch = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        $lastlogs = Logger::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();

        $searches = \Yii::$app->cache->getOrSet('admin-searches-full', function () {
            return SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select count(`id`) from `search_query`'
        ]));

        $logs = \Yii::$app->cache->getOrSet('admin-logs-full', function () {
            return Logger::find()->orderBy(['created_at' => SORT_DESC])->limit(500)->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select count(`id`) from `logger`'
        ]));


        $ordersNow = Order::find()->leftJoin('order_date', 'order.id=order_date.order_id')
            ->where(['order_date.date' => \Yii::$app->request->get('deliveryDate') ? \Yii::$app->request->get('deliveryDate') : date('d.m.Y')])
            ->andWhere(['is_close' => false])
            ->andWhere(['is_cancel' => false]);
        $ordersNow = $ordersNow->all();

        $no_attention_reviews = \Yii::$app->cache->getOrSet('no_attention_reviews', function () {
            return Reviews::find()->where(['is_active' => 1, 'status_id' => Reviews::STATUS_MODERATE])->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select count(id) from `reviews` where `is_active`=1 and `status_id`=' . Reviews::STATUS_MODERATE
        ]));


        return $this->render($this->view, [
            'searches' => $searches,
            'lastSearch' => $lastSearch,
            'no_attention_reviews' => $no_attention_reviews,
            'logs' => $logs,
            'lastlogs' => $lastlogs,
            'ordersNow' => $ordersNow,
        ]);
    }
}