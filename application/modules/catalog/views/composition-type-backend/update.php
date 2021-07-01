<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View */
/* @var $model mixed */
/* @var $searchModel \app\modules\catalog\models\search\CompositionSearchForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Title::show('Типы элемента состава: ' . $model->name);
?>
    <div class="title-group">
        <h1>Типы элемента состава: <?= $model->name; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
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