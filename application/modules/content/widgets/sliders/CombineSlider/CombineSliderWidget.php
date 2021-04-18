<?php

namespace app\modules\content\widgets\sliders\CombineSlider;


use app\modules\content\models\entity\SlidersImages;
use app\modules\content\models\helpers\SlidersImagesHelper;
use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\helpers\PromotionHelper;
use yii\base\Widget;

class CombineSliderWidget extends Widget
{
    public $view = 'default';
    public $sliderId;

    public function run()
    {
        $data = [];

        $promotions = Promotion::find()->where(['is_active' => true])->andWhere([
            'or',
            'start_at = :default and end_at = :default',
            'start_at is null and end_at is null',
            'start_at < :now and end_at > :now'
        ])
            ->addParams([
                ":now" => time(),
                ":default" => 0,
            ])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        foreach ($promotions as $promotion) {
            $this->extendDataArrayFromPromotion($promotion, $data);
        }


        $sliders = SlidersImages::find()->where(['active' => true, 'slider_id' => $this->sliderId])->all();
        foreach ($sliders as $slider) {
            $this->extendDataArrayFromSliderImage($slider, $data);
        }

        return $this->render($this->view, [
            'data' => $data
        ]);
    }

    public function extendDataArrayFromSliderImage(SlidersImages $image, &$data)
    {
        $data[] = [
            'imageUrl' => SlidersImagesHelper::getImageUrl($image),
            'link' => $image->link,
            'alt' => $image->text,
            'title' => $image->text,
        ];
    }

    public function extendDataArrayFromPromotion(Promotion $model, &$data)
    {
        $data[] = [
            'imageUrl' => PromotionHelper::getImageUrl($model),
            'link' => PromotionHelper::getDetailUrl($model),
            'alt' => $model->name,
            'title' => $model->name,
        ];
    }
}