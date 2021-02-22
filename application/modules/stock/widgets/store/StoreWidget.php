<?php

namespace app\modules\stock\widgets\store;


use app\modules\geo\models\entity\Geo;
use app\modules\stock\models\entity\Stocks;
use yii\base\Widget;

class StoreWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $city_id = null;

        if (!$city_id = \Yii::$app->session->get('city_id')) {
            $geo = Geo::findOne(['is_default' => true]);
            if ($geo) $city_id = $geo->id;
        }

        if (!$city_id) return false;

        $stock = Stocks::find()->where(['city_id' => $city_id])->one();

        return $this->render($this->view, [
            'stock' => $stock
        ]);
    }
}