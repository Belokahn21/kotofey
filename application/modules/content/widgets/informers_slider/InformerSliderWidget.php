<?php

namespace app\modules\content\widgets\informers_slider;


use app\modules\catalog\models\entity\PropertiesVariants;
use yii\base\Widget;

class InformerSliderWidget extends Widget
{
    public $template = 'default';
    public $cacheTime = 3600 * 24 * 7;
    public $cacheKey = 'informersSlider';

    public function run()
    {
        $cache = \Yii::$app->cache;

        $providers = $cache->getOrSet($this->cacheKey, function () {
            return PropertiesVariants::find()->select(['id', 'name', 'media_id', 'link', 'property_id'])->where(['is_active' => true, 'property_id' => 1])->all();
        }, $this->cacheTime);

        return $this->render($this->template, [
            'providers' => $providers
        ]);
    }
}