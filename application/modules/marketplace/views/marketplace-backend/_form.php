<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\marketplace\models\services\MarketplaceService;
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
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'is_active')->checkbox(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'shop_id'); ?>
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

            </div>
            <div class="col-sm-6">
                Список товаров площадки
                <?php
                $ms = new MarketplaceService();
                ?>
                <div class="marketplace-products">
                    <?php $ozon_stocks = $ms->countStock(); ?>
                    <?php foreach ($ms->getProducts() as $good) : ?>
                        <?php $product = Product::findOne(['article' => ArrayHelper::getValue($good, 'offer_id')]); ?>
                        <?php
                        $product_ozon_stock = false;
                        foreach ($ozon_stocks as $item) {
                            if ($item['offer_id'] == $product->article) $product_ozon_stock = $item;
                        }
                        ?>

                        <div class="marketplace-products-item">
                            <div class="marketplace-products-item__name"><?= $product->name; ?></div>
                            <div class="marketplace-products-item__stock site">Кол-во на складе: <?= $product->count; ?></div>
                            <div class="marketplace-products-item__stock marketplace">
                                Кол-во на Ozon
                                <?php foreach (ArrayHelper::getValue($product_ozon_stock, 'stocks') as $st): ?>
                                    <div><?= ArrayHelper::getValue($st, 'type') ?>: <?= ArrayHelper::getValue($st, 'present'); ?>/<?= ArrayHelper::getValue($st, 'reserved'); ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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