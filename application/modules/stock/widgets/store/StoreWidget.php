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
        $stock = Stocks::find()->where(['city_id' => $_SESSION['city_id']])->one();

        return $this->render($this->view, [
            'stock' => $stock
        ]);
    }
}