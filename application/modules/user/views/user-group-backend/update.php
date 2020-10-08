<?php

/* @var $this yii\web\View */

/* @var $model \app\modules\rbac\models\entity\AuthItem */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Title::showTitle("Управление группами");
?>
<?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
<h1 class="title">Группа: <?= $model->name; ?></h1>
<?php $form = ActiveForm::begin(); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
