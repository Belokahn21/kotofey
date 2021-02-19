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
        <?= $form->field($model, 'count'); ?>
        <?= $form->field($model, 'reason'); ?>
        <?= $form->field($model, 'order_id')->textInput(); ?>
        <?= $form->field($model, 'product_id')->textInput(); ?>
    </div>
</div>