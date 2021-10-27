<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use app\modules\media\models\entity\Media;
use app\modules\stock\models\entity\Stocks;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\ProductOrder;
use app\modules\catalog\models\entity\ProductStock;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\ProductToBreed;
use app\modules\site\models\helpers\ProductMarkupHelper;
use app\modules\catalog\models\helpers\ProductToBreadHelper;
use app\modules\catalog\models\helpers\ProductCategoryHelper;
use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;
use app\modules\marketplace\models\repository\MarketplaceRepository;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 * @var $properties \app\modules\catalog\models\entity\Properties[]
 * @var $form \yii\widgets\ActiveForm
 * @var $stocks Stocks[]
 * @var $prices \app\modules\catalog\models\entity\Price[]
 * @var $compositions \app\modules\catalog\models\entity\Composition[]
 * @var $vendors Vendor[]
 * @var $animals \app\modules\pets\models\entity\Animal[]
 * @var $breeds \app\modules\pets\models\entity\Breed[]
 * @var $this \yii\web\View
 */

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="false">Описание</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-pet-tab" data-toggle="tab" href="#nav-pet" role="tab" aria-controls="nav-pet" aria-selected="false">Питомец</a>
        <a class="nav-item nav-link" id="nav-stock-tab" data-toggle="tab" href="#nav-stock" role="tab" aria-controls="nav-stock" aria-selected="false">Складской учёт</a>
        <a class="nav-item nav-link" id="nav-composition-tab" data-toggle="tab" href="#nav-composition" role="tab" aria-controls="nav-composition" aria-selected="false">Состав товара</a>
        <a class="nav-item nav-link" id="nav-props-tab" data-toggle="tab" href="#nav-props" role="tab" aria-controls="nav-props" aria-selected="false">Свойства</a>
        <?php if (Yii::$app->hasModule('marketplace')): ?>
            <a class="nav-item nav-link" id="nav-marketplace-tab" data-toggle="tab" href="#nav-marketplace" role="tab" aria-controls="nav-marketplace" aria-selected="false">Маркетплейсы</a>
        <?php endif; ?>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4"><?= $form->field($model, 'status_id')->dropDownList($model->getStatusList(), ['prompt' => 'Статус товара'])->label(false); ?></div>
                    <div class="col-sm-4"><?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(ProductCategoryHelper::getInstance()->getFormated(), 'id', 'name'), ['prompt' => 'Раздел товара'])->label(false); ?></div>
                    <div class="col-sm-4"><?= $form->field($model, 'vendor_id')->dropDownList(ArrayHelper::map($vendors, 'id', 'name'), ['prompt' => 'Поставщик'])->label(false); ?></div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Название'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'slug')->textInput(['placeholder' => 'Символьный код'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"><?= $form->field($model, 'has_store')->checkbox()->label(false); ?></div>
                    <div class="col-sm-6"><?= $form->field($model, 'vitrine')->checkbox()->label(false); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'code')->textInput(['placeholder' => 'Внешний код'])->label(false); ?>
                    </div>

                    <div class="col-sm-4">
                        <?= $form->field($model, 'barcode')->textInput(['placeholder' => 'Штрих-код'])->label(false); ?>
                    </div>

                    <div class="col-sm-4">
                        <?= $form->field($model, 'ident_key')->textInput(['placeholder' => 'Специальный ключ'])->label(false); ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-element">
                            <?= $form->field($model, 'discount_price')->textInput(['placeholder' => 'Цена со скидкой'])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-element">
                            <?= $form->field($model, 'base_price')->textInput(['placeholder' => 'Базовая цена'])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-element">
                            <?= $form->field($model, 'purchase')->textInput(['id' => 'id-purchase', 'placeholder' => 'Закупочная цена'])->label(false); ?>
                        </div>
                    </div>

                    <div class="col-sm-3 set-price-container">
                        <div class="form-element">
                            <?= $form->field($model, 'price')->textInput(['id' => 'id-price', 'placeholder' => 'Цена продажи'])->label(false); ?>
                        </div>

                        <div class="set-price">
                            <input class="set-price__input form-control" placeholder="<?= ProductMarkupHelper::getProductMarkupFromCookie() ?>" value="<?= ProductMarkupHelper::getProductMarkupFromCookie(); ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-element">
                            <?= $form->field($model, 'count')->textInput(['placeholder' => 'Количество'])->label(false); ?>
                        </div>
                    </div>
                </div>

                <hr/>

                <h5>Условия доставки заказа</h5>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'is_product_order')->checkbox()->label(false); ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($modelDelivery, 'start')->dropDownList(ProductOrder::availableDays(), ['prompt' => 'Выбрать минимальное значение']); ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($modelDelivery, 'end')->dropDownList(ProductOrder::availableDays(), ['prompt' => 'Выбрать максимальное значение']); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-image single">
                            <?php if ($media = $model->media): ?>
                                <a data-lightbox="roadtrip" href="<?= ProductHelper::getImageUrl($model) ?>">
                                    <img src="<?= ProductHelper::getImageUrl($model) ?>" width="150" title="<?= $model->name; ?>" alt="<?= $model->name; ?>">
                                </a>
                                <?php if ($media->location == Media::LOCATION_SERVER): ?>
                                    Размер: <?= Yii::$app->formatter->asShortSize(filesize(Yii::getAlias('@webroot' . ProductHelper::getImageUrl($model)))); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php
                        $media_params = [];
                        if ($model->media) {
                            $media_params = [
                                'values' => [$model->media_id]
                            ];
                        }
                        echo $form->field($model, 'media_id')->widget(MediaBrowserWidget::className(), $media_params);
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false,
                    ],
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'instruction')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false,
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">
        <div class="form-element">
            <?= $form->field($model, 'seo_keywords'); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'seo_description')->textarea(); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'feed')->textarea(['id' => 'feed-replace']); ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-stock" role="tabpanel" aria-labelledby="nav-stock-tab">
        <div class="row">
            <div class="col-sm-6">
                <?php $price_product_model = new PriceProduct(); ?>
                <?php foreach ($prices as $count => $price): ?>

                    <?php $value = null; ?>
                    <?php if (!$model->isNewRecord): ?>
                        <?php $value = @PriceProduct::findOne(['product_id' => $model->id, 'price_id' => $price->id])->value; ?>
                    <?php endif; ?>

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
                <?php $stock_model = new ProductStock(); ?>
                <?php foreach ($stocks as $count => $stock): ?>

                    <?php $value = null; ?>
                    <?php if (!$model->isNewRecord): ?>
                        <?php $value = @ProductStock::findOne(['product_id' => $model->id, 'stock_id' => $stock->id])->count; ?>
                    <?php endif; ?>

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
    </div>
    <div class="tab-pane fade" id="nav-composition" role="tabpanel" aria-labelledby="nav-composition-tab">

        <?= $this->render('tabs/composition', [
            'form' => $form,
            'model' => $model,
            'compositions' => $compositions,
        ]); ?>

    </div>
    <div class="tab-pane fade" id="nav-pet" role="tabpanel" aria-labelledby="nav-pet-tab">

        <ul class="list-breeds">
            <?php foreach ((new \app\modules\pets\models\entity\Breed())->getSizes() as $key => $value): ?>
                <li class="list-breeds-item js-load-breed-sizes" data-key="<?= $key; ?>"><?= $value; ?></li>
            <?php endforeach; ?>
        </ul>

        <?php $ptb = new ProductToBreed(); ?>
        <?php $ptb_counter = 0; ?>

        <?php
        $model_id = $model->id;
        $ptb_models = Yii::$app->cache->getOrSet('value_ptb_model-' . $model_id, function () use ($model_id) {
            return ProductToBreed::find()->where(['product_id' => $model_id])->all();
        }) ?>
        <?php if ($ptb_models): ?>
            <?php foreach ($ptb_models as $ptb_counter => $ptb_model): ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($ptb_model, '[' . $ptb_counter . ']animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Указать животное']); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($ptb_model, '[' . $ptb_counter . ']breed_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ProductToBreadHelper::getGroupedItems(),
                        ]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($ptb, '[' . $ptb_counter . ']animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Указать животное']); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($ptb, '[' . $ptb_counter . ']breed_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => ProductToBreadHelper::getGroupedItems(),
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>


        <div class="row" style="display: none;" id="ptb-new-line">
            <div class="col-sm-6">
                <?= $form->field($ptb, '[#counter#]animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Указать животное']); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($ptb, '[#counter#]breed_id')->dropDownList(ProductToBreadHelper::getGroupedItems(), ['prompt' => 'Указать породу']); ?>
            </div>
        </div>

        <div class="js-add-new-line-area "></div>
        <div class="js-add-new-line-item add-new-line-button" data-target="#ptb-new-line" data-counter="<?= $ptb_counter; ?>">+</div>
    </div>
    <div class="tab-pane fade" id="nav-props" role="tabpanel" aria-labelledby="nav-props-tab">
        <?= $this->render('tabs/properties', [
            'form' => $form,
            'model' => $model,
            'properties' => $properties,
        ]); ?>
    </div>

    <?php if (Yii::$app->hasModule('marketplace')): ?>
        <div class="tab-pane fade" id="nav-marketplace" role="tabpanel" aria-labelledby="nav-marketplace-tab">
            <?php foreach (MarketplaceRepository::getAllMarketplace() as $marketplace): ?>
                <?= $marketplace->name; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<style type="text/css">
    .fieldset-props {
        display: block;
        margin-inline-start: 2px;
        margin-inline-end: 2px;
        border: groove 2px ThreeDFace;
        padding-block-start: 0.35em;
        padding-inline-end: 0.75em;
        padding-block-end: 0.625em;
        padding-inline-start: 0.75em;
        min-inline-size: min-content;
    }

    .fieldset-props legend {
        width: auto;
        padding-inline-start: 2px;
        padding-inline-end: 2px;
    }
</style>
