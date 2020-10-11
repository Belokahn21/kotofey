<?php
/* @var $this \yii\web\View
 * @var $model \app\modules\promocode\models\entity\Promocode
 */

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Title::showTitle("Промокоды");
?>
    <h1 class="title">Промокод: <?= $model->code; ?></h1>
<?= Html::a('Назад', ['index'], ['class' => 'btn-main']); ?>
<?php $form = ActiveForm::begin([
	'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
	'model' => $model,
	'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>