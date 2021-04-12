<?php

namespace app\modules\order\widgets\FindProductsWidgets;


use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class FindProducstWidgets extends Widget
{
    public $model;
    public $attribute;
    public $placeholder;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
        $modalId = substr(md5(rand()), 0, 5);

        echo Html::beginTag('div', [
            'style' => 'display:flex; flex-direction:row; margin:auto;'
        ]);
        echo Html::activeInput('text', $this->model, $this->attribute, [
            'class' => 'form-control load-product-info__pid',
            'placeholder' => $this->placeholder,
            'id' => 'uniq-' . $modalId,
        ]);

        echo Html::tag('div', '', [
            'class' => 'find-product-react',
            'data-options' => Json::encode([
                'modalId' => $modalId
            ])
        ]);
        echo Html::endTag('div');

    }
}