<?php

use yii\helpers\ArrayHelper;
use app\modules\vendors\models\entity\VendorGroup;

/* @var $model \app\modules\vendors\models\entity\VendorManager */
/* @var $vendors \app\modules\vendors\models\entity\Vendor[] */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-3"><?= $form->field($model, 'name'); ?></div>
            <div class="col-3"><?= $form->field($model, 'phone')->textInput(['class' => 'clean-phone form-control']); ?></div>
            <div class="col-3"><?= $form->field($model, 'email'); ?></div>
            <div class="col-3"><?= $form->field($model, 'vendor_id')->dropDownList(ArrayHelper::map($vendors, 'id', 'name'), ['prompt' => 'Поставщик']); ?></div>
        </div>
    </div>
</div>