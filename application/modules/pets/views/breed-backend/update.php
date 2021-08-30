<?php
/* @var $this \yii\web\View
 * @var $model
 * @var $animals \app\modules\pets\models\entity\Animal[]
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = \app\modules\seo\models\tools\Title::show($model->name);
?>

<div class="title-group">
    <h1>Породы</h1>
    <?= Html::a('Назад', \yii\helpers\Url::to(['index']), ['class' => 'btn-main']) ?>
</div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'animals' => $animals,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
