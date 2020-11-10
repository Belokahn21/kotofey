<?php

namespace app\modules\content\widgets\slider;

use app\modules\content\models\entity\SlidersImages;
use yii\base\Widget;

class SliderWidget extends Widget
{
    public $slider_id;
    public $view = 'default';
    public $time_cache;

    public function run()
    {
        if (empty($this->slider_id)) return;

        $unix_now = time();
        $cache = \Yii::$app->cache;
        $key = 'index-slider';
        $this->time_cache = 3600 * 60 * 24;

        $images = $cache->getOrSet($key, function () use ($unix_now) {
            return SlidersImages::find()->orderBy(['created_at' => SORT_DESC])->where(['active' => 1, 'slider_id' => $this->slider_id])->andWhere([
                'or',
                'start_at = :default and end_at = :default',
                'start_at is null and end_at is null',
                'start_at < :now and end_at > :now'
            ])
                ->addParams([
                    ":is_active" => 1,
                    ":slider_id" => $this->slider_id,
                    ":now" => $unix_now,
                    ":default" => 0,
                ])->all();
        }, $this->time_cache);

        return $this->render($this->view, [
            'images' => $images,
        ]);
    }
}