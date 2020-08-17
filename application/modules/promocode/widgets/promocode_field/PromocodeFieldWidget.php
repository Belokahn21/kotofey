<?php


namespace app\modules\promocode\widgets\promocode_field;

use yii\base\Widget;
use yii\helpers\Html;

class PromocodeFieldWidget extends Widget
{
    public $model;
    public $attribute;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();

        PromocodeFieldAssets::register($this->getView());

        return Html::activeInput('text', $this->model, $this->attribute, [
            'class' => 'checkout-form__input js-validate-promocode',
            'placeholder'=>'Воспользоваться промокодом'
        ]);
    }
}