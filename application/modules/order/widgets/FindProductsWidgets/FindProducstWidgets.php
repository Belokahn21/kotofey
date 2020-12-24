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
        $modalId = md5($modalId);

        echo Html::activeInput('text', $this->model, $this->attribute, [
            'class' => 'form-control load-product-info__pid',
            'placeholder' => 'PID',
            'data-target' => '#' . $modalId,
            'data-toggle' => 'modal'
        ]);

        echo Html::tag('div', '', [
            'class' => 'find-product',
            'data-options' => Json::encode([
                'modalId' => md5($this->attribute)
            ])
        ]);

    }
}