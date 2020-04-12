<?php

namespace app\widgets\slider;


use app\models\entity\SlidersImages;
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
            $images = SlidersImages::find()
                ->where(['slider_id' => $this->slider_id, 'active' => true])
                ->andWhere([
                    'and',
                    ['<', 'start_at', $unix_now],
                    ['>', 'end_at', $unix_now],
                ])
                ->orWhere([
                    'and',
                    ['start_at' => 0],
                    ['end_at' => 0],
                ])
                ->orWhere([
                    'and',
                    ['start_at' => null],
                    ['end_at' => null],
                ])
                ->orderBy(['created_at' => SORT_DESC]);

//            echo $images->createCommand()->getRawSql();
            $images = $images->all();
        }

        return $this->render($this->view, [
            'images' => $images,
        ]);
    }
}