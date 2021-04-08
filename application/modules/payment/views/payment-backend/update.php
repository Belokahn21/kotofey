<?php

/* @var $this yii\web\View
 * @var $model \app\modules\payment\models\entity\Payment
 */

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::show($model->name);
?>
<div class="title-group">
    <h1>Оплата: <?= $model->name; ?></h1>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
</div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
