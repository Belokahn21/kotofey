<?php

use yii\helpers\ArrayHelper;
use app\modules\media\models\entity\Media;

/* @var $model \app\modules\media\models\entity\MediaToEntity */
/* @var $form \yii\widgets\ActiveForm */
?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'media_id')->dropDownList(ArrayHelper::map(Media::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать Медиа']); ?>
        <?= $form->field($model, 'owner_object')->textInput(); ?>
    </div>
</div>

