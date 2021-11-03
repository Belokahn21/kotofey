<?php

use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use app\modules\media\models\entity\Media;
use app\modules\stock\models\entity\Stocks;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\ProductOrder;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\helpers\ProductMarkupHelper;
use app\modules\catalog\models\helpers\ProductCategoryHelper;
use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;

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
            <a class="nav-item nav-link" id="nav-marketplace-tab" data-toggle="tab" href="#nav-marketplace" role="tab" aria-controls="nav-props" aria-selected="false">Маркетплейсы</a>
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
                            <?php if ($model->media): ?>
                                <a data-lightbox="roadtrip" href="<?= ProductHelper::getImageUrl($model) ?>">
                                    <img src="<?= ProductHelper::getImageUrl($model) ?>" width="150" title="<?= $model->name; ?>" alt="<?= $model->name; ?>">
                                </a>
                                <?php if ($model->media->location == Media::LOCATION_SERVER): ?>
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
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'seo_keywords'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'seo_description')->textarea(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'feed')->textarea(['id' => 'feed-replace']); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-stock" role="tabpanel" aria-labelledby="nav-stock-tab">
        <?= $this->render('tabs/prices', [
            'form' => $form,
            'model' => $model,
            'prices' => $prices,
            'stocks' => $stocks,
        ]); ?>
    </div>
    <div class="tab-pane fade" id="nav-composition" role="tabpanel" aria-labelledby="nav-composition-tab">
        <?= $this->render('tabs/compositions', [
            'form' => $form,
            'model' => $model,
            'compositions' => $compositions,
        ]); ?>
    </div>
    <div class="tab-pane fade" id="nav-pet" role="tabpanel" aria-labelledby="nav-pet-tab">
        <?= $this->render('tabs/animals', [
            'form' => $form,
            'model' => $model,
            'animals' => $animals,
        ]); ?>
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
            <?= $this->render('tabs/market', [
                'form' => $form,
                'model' => $model,
            ]); ?>
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
