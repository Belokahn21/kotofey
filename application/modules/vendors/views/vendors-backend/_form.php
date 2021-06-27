<?php

use yii\helpers\ArrayHelper;
use app\modules\vendors\models\entity\VendorGroup;

/* @var $model \app\modules\vendors\models\entity\Vendor */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?= $form->field($model, 'is_active')->checkbox(); ?>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-element">
                    <?= $form->field($model, 'name')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-element">
                    <?= $form->field($model, 'legal_name')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'address')->textInput(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'sort')->textInput(); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-element">
                    <?= $form->field($model, 'delivery_days')->dropDownList([
                        '1' => 'Понедельник',
                        '2' => 'Вторник',
                        '3' => 'Среда',
                        '4' => 'Четверг',
                        '5' => 'Пятница',
                        '6' => 'Суббота',
                        '7' => 'Воскресение',
                    ], ['prompt' => 'Дни доставки', 'multiple' => true, 'size' => 8]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-element">
                    <?= $form->field($model, 'email')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'phone')->textInput(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'how_send_order')->dropDownList($model->getSendOrderVariants(), ['prompt' => 'Заявка отправляется через']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-element">
                    <?= $form->field($model, 'discount')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(VendorGroup::find()->all(), 'id', 'name'), ['prompt' => 'Группа поставщиков']) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'min_summary_sale')->textInput(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'type_price')->dropDownList($model->getTypePrice(), ['prompt' => 'Цена в прайсе']); ?>
            </div>
        </div>
    </div>
</div>