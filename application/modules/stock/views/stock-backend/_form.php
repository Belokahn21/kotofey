<?php

use yii\helpers\ArrayHelper;
use app\modules\geo\models\entity\Geo;

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-time-tab" data-toggle="tab" href="#nav-time" role="tab" aria-controls="nav-time" aria-selected="false">Время работы</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'address'); ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
        <?= $form->field($model, 'active')->checkbox(); ?>
        <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->all(), 'id', 'name'), ['prompt' => 'Выбрать город']); ?>

    </div>
    <div class="tab-pane fade" id="nav-time" role="tabpanel" aria-labelledby="nav-time-tab">
        <div class="row">
            <div class="col-sm-6">
                <p>Время открытия</p>
                <?= $form->field($model, 'hour_start')->dropDownList(range(0, 23)); ?>
                <?= $form->field($model, 'minute_start')->dropDownList(range(0, 59)); ?>
            </div>
            <div class="col-sm-6">
                <p>Время закрытия</p>
                <?= $form->field($model, 'hour_end')->dropDownList(range(0, 23)); ?>
                <?= $form->field($model, 'minute_end')->dropDownList(range(0, 59)); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
    </div>
</div>
