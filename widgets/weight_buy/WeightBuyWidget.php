<?php

namespace app\widgets\weight_buy;


use app\models\forms\WeightBuyForm;
use app\widgets\notification\Alert;
use yii\base\Widget;

class WeightBuyWidget extends Widget
{
    public $template = 'default';
    public $product_id;

    public function run()
    {
        $model = new WeightBuyForm();

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->addBasket()) {
                    Alert::setSuccessNotify('Успешно добавлено в корзину');
                    return "";
                }
            }
        }

        return $this->render($this->template, [
            'product_id' => $this->product_id,
            'model' => $model
        ]);
    }
}