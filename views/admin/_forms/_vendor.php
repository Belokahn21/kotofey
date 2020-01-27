<?php

use yii\helpers\ArrayHelper;
use app\models\entity\VendorGroup;

/* @var $model \app\models\entity\Vendor */

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
            <div class="col-sm-6">
                <div class="form-element">
					<?= $form->field($model, 'name')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-element">
					<?= $form->field($model, 'legal_name')->textInput(); ?>
                </div>
            </div>
        </div>
        <div class="form-element">
			<?= $form->field($model, 'address')->textInput(); ?>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-element">
					<?= $form->field($model, 'sort')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-element">
					<?= $form->field($model, 'discount')->textInput(); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-element">
					<?= $form->field($model, 'min_summary_sale')->textInput(); ?>
                </div>
            </div>
        </div>
        <div class="form-element">
			<?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(VendorGroup::find()->all(), 'id', 'name'), ['prompt' => 'Группа поставщиков']) ?>
        </div>
    </div>
</div>