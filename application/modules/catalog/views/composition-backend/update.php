<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\Product
 */

$this->title = Title::show('Элемент состава: ' . $model->name);
?>
    <div class="title-group">
        <h1>Элемент состава: <?= $model->name; ?></h1>
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