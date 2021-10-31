<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\stock\models\entity\Stocks;
use app\modules\catalog\models\helpers\StockHelper;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\ProductStock;
use app\modules\catalog\models\helpers\PriceListHelper;
use app\modules\catalog\models\repository\PriceRepository;
use app\modules\catalog\models\repository\StockRepository;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $form \yii\widgets\ActiveForm
 * @var $stocks Stocks[]
 * @var $prices \app\modules\catalog\models\entity\Price[]
 * @var $this \yii\web\View
 */

?>
<div class="row">
    <div class="col-sm-6">
        <?php
        $price_product_model = new PriceProduct();
        $price_values = [];
        if (!$model->isNewRecord) {
            $price_ids = ArrayHelper::map($prices, 'id', 'id');
            $price_values = PriceRepository::getValues($model->id, $price_ids);
        }

        ?>
        <?php foreach ($prices as $count => $price): ?>

            <?php $value = null; ?>
            <?php if (!$model->isNewRecord):
                $value = PriceListHelper::getValue($price_values, $model->id, $price->id);
                if ($value instanceof PriceProduct) $value = $value->value;
            endif; ?>

            <div class="row">
                <div class="col-12">
                    <?= $form->field($price_product_model, '[' . $count . ']price_id')->hiddenInput(['value' => $price->id])->label(false); ?>
                    <?= $form->field($price_product_model, '[' . $count . ']product_id')->hiddenInput(['value' => $model->id])->label(false); ?>
                    <?= $form->field($price_product_model, '[' . $count . ']value')->textInput([
                        'placeholder' => $price->name,
                        'value' => $value
                    ])->label(Html::a($price->name, Url::to(['/admin/catalog/price-backend/update', 'id' => $price->id]), ['target' => '_blank'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-6">
        <?php
        $stock_model = new ProductStock();
        $stock_values = [];
        if (!$model->isNewRecord) {
            $stock_ids = ArrayHelper::map($prices, 'id', 'id');
            $stock_values = StockRepository::getValues($model->id, $stock_ids);
        }
        ?>
        <?php foreach ($stocks as $count => $stock): ?>

            <?php $value = null; ?>
            <?php
            if (!$model->isNewRecord) {
                $value = StockHelper::getValue($stock_values, $model->id, $stock->id);
                if ($value instanceof ProductStock) $value = $value->value;
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <?= $form->field($stock_model, '[' . $count . ']stock_id')->hiddenInput(['value' => $stock->id])->label(false); ?>
                    <?= $form->field($stock_model, '[' . $count . ']product_id')->hiddenInput(['value' => $model->id])->label(false); ?>
                    <?= $form->field($stock_model, '[' . $count . ']count')->textInput([
                        'placeholder' => 'Количество на ' . $stock->name . " ({$stock->address})",
                        'value' => $value
                    ])->label(Html::a($stock->name . " (<strong>{$stock->address}</strong>)", Url::to(['/admin/stock/stock-backend/update', 'id' => $stock->id]), ['target' => '_blank'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>