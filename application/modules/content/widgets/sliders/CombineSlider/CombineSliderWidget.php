<?php

namespace app\modules\content\widgets\sliders\CombineSlider;


use app\modules\content\models\entity\SlidersImages;
use app\modules\content\models\helpers\SlidersImagesHelper;
use yii\base\Widget;

class CombineSliderWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $data = [];

        $sldiers = SlidersImages::find()->all();

        foreach ($sliders as $slider) {
            $this->extendDataArray($slider, $data);
        }

        return $this->render($this->view, [
            'data' => $data
        ]);
    }

    public function extendDataArray(SlidersImages $image, &$data)
    {
        $data[] = [
            'imageUrl' => SlidersImagesHelper::getImageUrl($image),
            'link' => $image->link
        ];
    }
}