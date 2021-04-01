<?php

use yii\helpers\ArrayHelper;
use app\modules\geo\models\entity\Geo;

/* @var $model \app\modules\site_settings\models\entity\SiteSettings
 * @var $form \yii\widgets\ActiveForm
 */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'code'); ?>
        <?= $form->field($model, 'value'); ?>
        <?= $form->field($model, 'type'); ?>

    </div>
</div>
