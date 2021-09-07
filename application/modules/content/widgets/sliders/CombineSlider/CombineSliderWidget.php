<?php

namespace app\modules\content\widgets\sliders\CombineSlider;


use app\modules\content\models\entity\SlidersImages;
use app\modules\content\models\helpers\SlidersImagesHelper;
use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\helpers\PromotionHelper;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;
use yii\caching\DbDependency;

class CombineSliderWidget extends Widget
{
    public $view = 'default';
    public $sliderId;

    public function run()
    {
        $data = [];

        $promotions = PromotionHelper::getActualPromotions();

        foreach ($promotions as $promotion) {
            $this->extendDataArrayFromPromotion($promotion, $data);
        }


        $sliders = \Yii::$app->cache->getOrSet(__METHOD__ . __FILE__ . '-sliders', function () {
            return SlidersImages::find()->where(['active' => true, 'slider_id' => $this->sliderId])->orderBy(['created_at' => SORT_DESC])->all();
        }, 3600 * 24 * 60, new DbDependency([
            'sql' => 'select count(`id`) from `sliders_images`',
        ]));

        foreach ($sliders as $slider) {
            $this->extendDataArrayFromSliderImage($slider, $data);
        }

        usort($data, function ($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }
            return ($a['sort'] > $b['sort']) ? -1 : 1;
        });

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
            'sort' => $image->sort,
        ];
    }

    public function extendDataArrayFromPromotion(Promotion $model, &$data)
    {
        $data[] = [
            'imageUrl' => PromotionHelper::getImageUrl($model),
            'link' => PromotionHelper::getDetailUrl($model),
            'alt' => $model->name,
            'title' => $model->name,
            'sort' => $model->sort,
        ];
    }
}