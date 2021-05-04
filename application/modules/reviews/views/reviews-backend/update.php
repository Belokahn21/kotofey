<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\helpers\Url;

/* @var $model \app\modules\reviews\models\entity\Reviews */


$this->title = Title::show("Обновить отзыв: " . $model->id);
?>
    <div class="title-group">
        <h1>Обновить отзыв: #<?= $model->id; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
        <?= Html::a('Удалить', Url::to(['delete', 'id' => $model->id]), ['class' => 'btn-main']) ?>
    </div>

<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>