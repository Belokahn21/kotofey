<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $model \app\modules\order\models\entity\OrderStatus */
/* @var $this \yii\web\View */
?>
<?php $this->title = Title::show("Статус: " . $model->name); ?>
<section>
    <h1 class="title">Статус: <?= $model->name; ?></h1>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form
    ]) ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>
