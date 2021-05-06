<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\NotifyAdmission
 */

$this->title = Title::show('Запросы на уведомление');
?>
    <div class="title-group">
        <h1>Запросы на уведомление от <?= $model->email; ?></h1>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>