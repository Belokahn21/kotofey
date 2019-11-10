<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Order;

?>
<?php $form = ActiveForm::begin(); ?>
<?= Html::hiddenInput('type', Order::SCENARIO_FAST_ORDER) ?>
<?= Html::submitButton('Купить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>