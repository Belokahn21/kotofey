<?php

namespace app\modules\catalog\widgets\CatalogSliders\RenderSlider;


use yii\base\Widget;

class RenderSliderWidget extends Widget
{
    public $view = 'default';
    public $models = [];
    public $title = "";
    public $subTitle = "";

    public function run()
    {
        return $this->render($this->view, [
            'models' => $this->models,
            'title' => $this->title,
            'subTitle' => $this->subTitle,
        ]);
    }
}