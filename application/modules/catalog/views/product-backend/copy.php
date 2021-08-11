<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $stocks \app\modules\stock\models\entity\Stocks[] */
/* @var $prices \app\modules\catalog\models\entity\Price[] */

$this->title = Title::show('Товары');
?>
    <div class="title-group">
        <h1>Скопировать: <?= $model->name; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'stocks' => $stocks,
    'prices' => $prices,
    'animals' => $animals,
    'breeds' => $breeds,
    'compositions' => $compositions,
    'properties' => $properties,
    'modelDelivery' => $modelDelivery,
]) ?>
<?= Html::submitButton('Скопировать', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>