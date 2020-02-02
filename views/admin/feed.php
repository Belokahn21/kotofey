<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $property_values \app\models\entity\InformersValues[] */
/* @var $model \app\models\forms\FeedmakerForm */

$this->title = Title::showTitle("Поисковой контент по производителям");
?>
    <h1>Поисковой контент по производителям</h1>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'attribute')->dropDownList(ArrayHelper::map($property_values, 'id', 'name')); ?>
<?= $form->field($model, 'feed')->textarea(); ?>
<?= Html::submitButton('Выполнить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>