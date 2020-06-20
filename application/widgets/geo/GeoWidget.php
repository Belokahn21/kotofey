<?php

namespace app\widgets\geo;

use app\models\tool\geo\CityDefine;
use yii\base\Widget;
use app\models\entity\Geo;

class GeoWidget extends Widget
{
    public $template = 'default';
    public $time_cache;

    public function run()
    {
        $cache = \Yii::$app->cache;
        $key = GeoWidget::className();
        $this->time_cache = 3600 * 60 * 24;

        $cities = $cache->getOrSet($key, function () {
            return Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->andWhere(['active' => 1])->all();
        }, $this->time_cache);

        return $this->render($this->template, [
            'cities' => $cities
        ]);
    }


}
