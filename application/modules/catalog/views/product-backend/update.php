<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $properties \app\modules\catalog\models\entity\ProductProperties[] */
/* @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder */

$this->title = Title::showTitle('Товары');
?>
<?= Html::a('Назад', \yii\helpers\Url::to(['index']), ['class' => 'btn-main']); ?>
<?= Html::a("Посмотреть на сайте", $model->detail, ['target' => '_blank', 'class' => 'btn-main']); ?>
    <h1 class="title"><?= $model->name; ?></h1>
<?php $form = ActiveForm::begin([
//    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'properties' => $properties,
    'modelDelivery' => $modelDelivery,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>