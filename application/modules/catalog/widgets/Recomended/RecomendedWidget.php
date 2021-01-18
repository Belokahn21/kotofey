<?php


namespace app\modules\catalog\widgets\Recomended;


use app\modules\catalog\models\entity\Product;
use yii\base\Widget;

class RecomendedWidget extends Widget
{
    public $view = 'default';
    public $property_id;

    public function run()
    {
        $models = Product::find()->joinWith('propsValues')->where(['propsValues.property_id' => $this->property_id])->all();

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}