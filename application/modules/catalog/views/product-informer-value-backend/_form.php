<?php

use app\modules\catalog\models\entity\Informers;
use yii\helpers\ArrayHelper;

/* @var $model \app\modules\catalog\models\entity\InformersValues */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id', 'name'), ['prompt' => 'Справочник']) ?>
        <?= $form->field($model, 'active')->checkbox() ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]) ?>
        <?= $form->field($model, 'link')->textInput() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'description')->textarea() ?>
    </div>
    <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">
    </div>
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
        <?php if ($model->image): ?>
            <img src="/upload/<?= $model->image; ?>">
        <?php endif; ?>

        <?= $form->field($model, 'image')->fileInput() ?>
    </div>
</div>