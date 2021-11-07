<?php

namespace app\modules\statistic\widgets;


use app\modules\catalog\models\entity\NotifyAdmission;
use app\modules\logger\models\entity\Logger;
use app\modules\marketplace\models\entity\MarketplaceProductStatus;
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
            return SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select count(`id`) from `search_query`'
        ]));

        $logs = \Yii::$app->cache->getOrSet('admin-logs-full', function () {
            return Logger::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
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
            'sql' => 'select count(*) from `reviews` where `is_active`=1 and `status_id`=' . Reviews::STATUS_MODERATE
        ]));

        $last_admission = \Yii::$app->cache->getOrSet('last_admission', function () {
            return NotifyAdmission::find()->where(['is_active' => true])->orderBy(['created_at' => SORT_DESC])->limit(3)->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select count(*) from `notify_admission`'
        ]));

        $ozon_new =\Yii::$app->cache->getOrSet('last-five-marketplasce-history', function () {
            return MarketplaceProductStatus::find()->limit(5)->orderBy(['created_at' => SORT_DESC])->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select max(`id`) from `marketplace_product_status`'
        ]));


        return $this->render($this->view, [
            'searches' => $searches,
            'lastSearch' => $lastSearch,
            'no_attention_reviews' => $no_attention_reviews,
            'last_admission' => $last_admission,
            'logs' => $logs,
            'lastlogs' => $lastlogs,
            'ordersNow' => $ordersNow,
            'ozon_new' => $ozon_new,
        ]);
    }
}