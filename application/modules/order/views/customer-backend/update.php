<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $properties \app\modules\catalog\models\entity\PropertyGroup[]
 * @var $model \app\modules\catalog\models\entity\Properties
 * @var $propertiesValues \app\modules\order\models\entity\CustomerPropertiesValues
 */

$this->title = Title::show("Свойство покупателя"); ?>
<section>
    <div class="title-group">
        <h1 class="title">Свойство покупателя: <?= $model->name; ?></h1>
        <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
        'properties' => $properties,
        'propertiesValues' => $propertiesValues,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>