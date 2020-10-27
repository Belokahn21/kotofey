<?php

namespace app\modules\content\widgets\informers_slider;


use app\modules\catalog\models\entity\InformersValues;
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
            return InformersValues::find()->select(['id', 'name', 'image','media_id'])->where(['active' => true, 'informer_id' => 1])->orderBy(['sort' => SORT_DESC]);
        }, $this->cacheTime);

        return $this->render($this->template, [
            'providers' => $providers
        ]);
    }
}