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

        echo Html::activeInput('text', $this->model, $this->attribute, [
            'class' => 'checkout-form__input js-validate-promocode',
            'placeholder' => 'Воспользоваться промокодом'
        ]);
        echo Html::hiddenInput('promocode-discount', false, [
            'class' => 'js-promocode-amount',
        ]);

        echo Html::tag('div', "Ваш промокод: " . Html::tag('span', '', ['class' => 'checkout-form-promocode__code']) . Html::tag('span', '', ['class' => 'checkout-form-promocode__discount']), [
            'class' => 'checkout-form-promocode',
        ]);

    }
}