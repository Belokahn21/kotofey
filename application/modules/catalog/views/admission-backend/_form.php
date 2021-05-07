<?php

use app\modules\catalog\models\entity\Product;

/* @var $model \app\modules\catalog\models\entity\NotifyAdmission
 * @var $form \yii\widgets\ActiveForm
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
            <div class="col-6">
                <div class="row">
                    <div class="col-4"><?= $form->field($model, 'is_active')->checkbox(); ?></div>
                    <div class="col-4"><?= $form->field($model, 'email')->label(false); ?></div>
                    <div class="col-4"><?= $form->field($model, 'product_id')->label(false); ?></div>
                </div>
            </div>
            <div class="col-6">
                <?php if ($product = Product::findOne($model->product_id)): ?>
                    <h5><?= $product->name; ?>[<?= $product->status_id == Product::STATUS_ACTIVE ? '<span class="green">Активен</span>' : '<span class="red">Не активен</span>'; ?>]</h5>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>