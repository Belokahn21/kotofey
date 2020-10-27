<?php

use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Informers;
use app\modules\media\widgets\InputUploadWidget\InputUploadWidget;

/* @var $model \app\modules\catalog\models\entity\InformersValues */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'active')->checkbox() ?>
        <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id', 'name'), ['prompt' => 'Справочник']) ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]) ?>
        <?= $form->field($model, 'link')->textInput() ?>
        <?= $form->field($model, 'description')->textarea() ?>

        <?php if ($model->image): ?>
            <img src="/upload/<?= $model->image; ?>">
        <?php endif; ?>
        <?= $form->field($model, 'image')->widget(InputUploadWidget::className()) ?>
    </div>
</div>