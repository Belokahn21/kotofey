<?php

use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

/* @var $model \app\models\entity\InformersValues */

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
    </ul>

    <div id="tab-1" class="tab-content current">
        <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id', 'name'), ['prompt' => 'Справочник']) ?>
        <?= $form->field($model, 'active')->checkbox() ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]) ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'description')->textarea() ?>

        <?php if ($model->image): ?>
            <img src="/web/upload/<?= $model->image; ?>" width="200">
        <?php endif; ?>

        <?= $form->field($model, 'image')->fileInput() ?>
    </div>

</div>