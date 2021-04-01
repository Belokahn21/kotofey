<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\stock\models\entity\Stocks */

?>
<?php $this->title = Title::show($model->name); ?>
<section>
    <div class="title-group">
        <h1 class="title">Склад: <?= $model->name; ?></h1>
        <?= Html::a("Назад", ['index'], ['class' => 'btn-main']) ?>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>