<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $properties \app\modules\catalog\models\entity\ProductProperties[] */
/* @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder */

$this->title = Title::showTitle('Товары');
?>
    <div class="title-group">
        <h1><?= $model->name; ?></h1>
        <?= Html::a('Назад', \yii\helpers\Url::to(['index']), ['class' => 'btn-main']); ?>
        <?= Html::a("Посмотреть на сайте", $model->detail, ['target' => '_blank', 'class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
    Наценка: <?= floor((($model->price - $model->purchase) / $model->purchase) * 100); ?>
    Наценка: <?= \app\modules\catalog\models\helpers\ProductHelper::getMarkup($model); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'properties' => $properties,
    'modelDelivery' => $modelDelivery,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>