<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $propertyGroup \app\modules\catalog\models\entity\PropertyGroup[]
 * @var $model \app\modules\catalog\models\entity\Properties
 */

$this->title = Title::showTitle("Свойства товаров"); ?>
<section>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    <h1 class="title">Свойство: <?= $model->name; ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
        'propertyGroup' => $propertyGroup,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>