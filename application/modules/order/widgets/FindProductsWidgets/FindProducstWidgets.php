<?php

namespace app\modules\order\widgets\FindProductsWidgets;


use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class FindProducstWidgets extends Widget
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

        $modalId = 'modal_' . $this->attribute;
        $modalId = md5(rand());

        echo Html::activeInput('text', $this->model, $this->attribute, [
            'class' => 'form-control load-product-info__pid',
            'id' => 'uniq-' . $modalId,
            'style' => 'width:40px; display:inline-block;'
        ]);

        echo Html::tag('div', '+', [
            'data-target' => '#' . $modalId,
            'data-toggle' => 'modal',
            'style' => 'border:1px solid grey; display:inline-block; width:20px; height:30px; text-align:center; cursor:pointer;'
        ]);

        echo Html::tag('div', '', [
            'class' => 'find-product',
            'data-options' => Json::encode([
                'modalId' => $modalId
            ])
        ]);

    }
}