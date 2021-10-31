<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\marketplace\models\repository\MarketplaceProductRepository;

/* @var $model \app\modules\marketplace\models\entity\Marketplace
 * @var $form \yii\widgets\ActiveForm
 */


?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-generals-edit-tab" data-toggle="tab" href="#nav-generals-edit" role="tab" aria-controls="nav-generals-edit" aria-selected="false">Основное</a>
        <?php if (!$model->isNewRecord): ?>
            <a class="nav-item nav-link" id="nav-products-edit-tab" data-toggle="tab" href="#nav-products-edit" role="tab" aria-controls="nav-products-edit" aria-selected="false">Товары</a>
        <?php endif; ?>
    </div>
</nav>


<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-generals-edit" role="tabpanel" aria-labelledby="nav-generals-edit-tab">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'is_active')->checkbox(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'name'); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'type_export_id')->dropDownList($model->getTypeExports(), ['prompt' => 'Выгрузка товаров']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'shop_id'); ?>
            </div>
        </div>
    </div>
    <?php if (!$model->isNewRecord): ?>
        <div class="tab-pane fade " id="nav-products-edit" role="tabpanel" aria-labelledby="nav-products-edit-tab">
            <?php foreach (MarketplaceProductRepository::getAllForPlace($model->id) as $value): ?>
                <?php $product = $value->product; ?>
                <?= Html::a('[' . $product->article . '] ' . $product->name, Url::to(['product-backend/update', 'id' => $product->id])); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>