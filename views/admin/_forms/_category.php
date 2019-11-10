<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $categories \app\models\entity\Category[] */
/* @var $model \app\models\entity\Category */

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
        <li class="tab-link" data-tab="tab-2">SEO</li>
        <li class="tab-link" data-tab="tab-3">Галлерея</li>
    </ul>

    <div id="tab-1" class="tab-content current">
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($categories, 'id', 'name'), ['prompt' => 'Родительская категория']); ?>
        <?= $form->field($model, 'sort'); ?>
    </div>
    <div id="tab-2" class="tab-content">
        <?= $form->field($model, 'seo_keywords'); ?>
        <?= $form->field($model, 'seo_description'); ?>
    </div>
    <div id="tab-3" class="tab-content">
        <?php if ($model->image): ?>
            <?= Html::img('/web/upload/' . $model->image, ['width' => 200]); ?>
        <?php endif; ?>
        <?= $form->field($model, 'image')->fileInput(); ?>
    </div>

</div>