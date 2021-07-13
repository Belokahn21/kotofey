<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \app\modules\catalog\models\entity\Offers */

$this->title = \app\modules\seo\models\tools\Title::show('Товары');
?>

    <div class="title-group">
        <h1>Товары</h1>
        <?= Html::a('Предложения', Url::to(['/admin/catalog/offers-backend/index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>