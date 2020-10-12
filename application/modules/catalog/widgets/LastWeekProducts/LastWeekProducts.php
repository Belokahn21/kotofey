<?php


namespace app\modules\catalog\widgets\LastWeekProducts;

use app\modules\catalog\models\entity\Product;
use yii\bootstrap\Widget;

class LastWeekProducts extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = Product::find()->where(['between', 'created_at', time() - 604800, time()])->all();

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}