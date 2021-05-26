<?php


namespace app\modules\order\widgets\CustomerInput;


use yii\base\Widget;
use yii\helpers\Html;

class CustomerInputWidget extends Widget
{
    public $model;
    public $attribute;

    public function run()
    {
        // render by react
        return Html::tag('div', false, ['class' => 'find-customer-react']);
    }
}