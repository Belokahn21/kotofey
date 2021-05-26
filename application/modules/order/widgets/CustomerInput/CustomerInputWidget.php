<?php


namespace app\modules\order\widgets\CustomerInput;


use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class CustomerInputWidget extends Widget
{
    public $model;
    public $attribute;
    public $placeholder;

    public function run()
    {
        // render by react

        parent::run();

        $modalId = time();

        echo Html::beginTag('div', [
            'style' => 'display:flex; flex-direction:row; margin:auto;'
        ]);
        echo Html::activeInput('text', $this->model, $this->attribute, [
            'class' => 'form-control load-product-info__pid',
            'placeholder' => $this->placeholder,
            'id' => 'uniq-' . $modalId,
        ]);

        echo Html::tag('div', null, ['class' => 'find-customer-react', 'data-options' => Json::encode([
            'name' => 'Order[' . $this->attribute . ']'
        ])]);


        echo Html::endTag('div');
    }
}