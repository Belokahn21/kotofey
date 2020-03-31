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
            $images = SlidersImages::find()->where(['slider_id' => $this->slider_id, 'active' => true])->orderBy(['created_at' => SORT_DESC])->all();
        }

        return $this->render($this->view, [
            'images' => $images,
        ]);
    }
}