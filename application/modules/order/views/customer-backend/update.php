<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $properties \app\modules\catalog\models\entity\PropertyGroup[]
 * @var $model \app\modules\catalog\models\entity\Properties
 * @var $propertiesValues \app\modules\order\models\entity\CustomerPropertiesValues
 * @var $customer_status \app\modules\order\models\entity\CustomerStatus[]
 */

$this->title = Title::show("Покупатель: " . $model->name); ?>
<section>
    <div class="title-group">
        <h1 class="title">Покупатель: <?= $model->name; ?></h1>
        <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
        'properties' => $properties,
        'propertiesValues' => $propertiesValues,
        'customer_status' => $customer_status,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>