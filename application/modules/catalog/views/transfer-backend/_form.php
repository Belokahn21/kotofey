<?php

use yii\helpers\ArrayHelper;

/* @var $model \app\modules\catalog\models\entity\ProductTransferHistory
 * @var $form \yii\widgets\ActiveForm
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $products \app\modules\catalog\models\entity\Product[]
 */

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'count'); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'order_id')->textInput(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'product_id')->textInput(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'operation_id')->dropDownList($model->getOperations(), ['prompt' => 'Операция по товару']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'reason'); ?>
            </div>
        </div>
    </div>
</div>