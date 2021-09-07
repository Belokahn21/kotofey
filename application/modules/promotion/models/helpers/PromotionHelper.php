<?php


namespace app\modules\promotion\models\helpers;


use app\modules\promotion\models\entity\Promotion;
use yii\helpers\Url;

class PromotionHelper
{
    public static function getDetailUrl(Promotion $model)
    {
        return Url::to(['/promotion/promotion/view', 'id' => $model->slug]);
    }

    public static function getImageUrl(Promotion $model, $options = [])
    {
        return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);
    }

    public static function getActualPromotions($sort = ['created_at' => SORT_DESC, 'sort' => SORT_DESC])
    {
        $promotions = \Yii::$app->cache->getOrSet('actual-promotions', function () use ($sort) {
            return Promotion::find()->where(['is_active' => true])->andWhere([
                'or',
                'start_at = :default and end_at = :default',
                'start_at is null and end_at is null',
                'start_at < :now and end_at > :now'
            ])
                ->addParams([
                    ":now" => time(),
                    ":default" => 0,
                ])
                ->orderBy($sort)
                ->all();
        }, \Yii::$app->params['cache_time']);

        return $promotions;
    }
}