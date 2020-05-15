<?php

namespace app\widgets\slider;


use app\modules\content\models\entity\SlidersImages;
use yii\base\Widget;

class SliderWidget extends Widget
{
    public $slider_id;
    public $use_carousel;
    public $view = 'default';

    public function run()
    {
        $images = [];
        if (!empty($this->slider_id)) {
            $unix_now = time();

            $images = SlidersImages::find()->orderBy(['created_at' => SORT_DESC])->where(['active' => 1, 'slider_id' => $this->slider_id])->andWhere([
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
                ]);

            $images = $images->all();

        }

        return $this->render($this->view, [
            'images' => $images,
        ]);
    }
}