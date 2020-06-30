<?php

use app\models\entity\ProductOrder;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\stock\models\entity\Stocks;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\InformersValues;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use yii\helpers\Json;
use app\modules\vendors\models\entity\Vendor;
use app\modules\settings\models\helpers\MarkupHelpers;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $modelDelivery \app\models\entity\ProductOrder */
/* @var $properties \app\modules\catalog\models\entity\ProductProperties[] */

?>

<div class="catalog-control">
    <div class="pre-load-catalog-wrap">
        <input type="text" name="url" placeholder="Ссылка на подгрузку" class="pre-load-catalog">
        <svg width="20" height="30" class="backend-preloader hide">
            <rect width="10%" x="5%" rx="5%">
                <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" repeatCount="indefinite"></animate>
                <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" repeatCount="indefinite"></animate>
            </rect>

            <rect width="10%" x="25%" rx="5%">
                <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.15s" repeatCount="indefinite"></animate>
                <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.15s" repeatCount="indefinite"></animate>
            </rect>

            <rect width="10%" x="45%" rx="5%">
                <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.3s" repeatCount="indefinite"></animate>
                <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.3s" repeatCount="indefinite"></animate>
            </rect>

            <rect width="10%" x="65%" rx="5%">
                <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.45s" repeatCount="indefinite"></animate>
                <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.45s" repeatCount="indefinite"></animate>
            </rect>

            <rect width="10%" x="85%" rx="5%">
                <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.6s" repeatCount="indefinite"></animate>
                <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.6s" repeatCount="indefinite"></animate>
            </rect>
        </svg>
    </div>
</div>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
        <a class="nav-item nav-link" id="nav-additional-tab" data-toggle="tab" href="#nav-additional" role="tab" aria-controls="nav-additional" aria-selected="false">Дополнительно</a>
        <a class="nav-item nav-link" id="nav-props-tab" data-toggle="tab" href="#nav-props" role="tab" aria-controls="nav-props" aria-selected="false">Свойства</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-element">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Название'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'description')->textarea(['placeholder' => 'Описание'])->label(false); ?>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map((new Category())->categoryTree(), 'id', 'name'), ['prompt' => 'Раздел товара'])->label(false); ?>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->all(), 'id', 'name'), ['prompt' => 'Поставщик'])->label(false); ?>
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

                    <div class="col-sm-3">
                        <div class="form-element">
                            <?= $form->field($model, 'price')->textInput(['id' => 'id-price', 'placeholder' => 'Цена продажи'])->label(false); ?>
                        </div>

                        <div class="set-price">
                            <input class="set-price__input" placeholder="<?= MarkupHelpers::getCurrentMarkupProduct(); ?>" value="<?= MarkupHelpers::getCurrentMarkupProduct(); ?>">
                            <a href="javascript:void(0);" class="set-price__action">% наценка</a>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-element">
                            <?= $form->field($model, 'count')->textInput(['placeholder' => 'Количество'])->label(false); ?>
                        </div>
                    </div>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'has_store')->checkbox()->label(false); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-title">
                    Условия доставки заказа
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'is_product_order')->checkbox()->label(false); ?>
                </div>

                <div class="form-element">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($modelDelivery, 'start')->dropDownList(ProductOrder::availableDays(), ['prompt' => 'Выбрать минимальное значение']); ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($modelDelivery, 'end')->dropDownList(ProductOrder::availableDays(), ['prompt' => 'Выбрать максимальное значение']); ?>
                        </div>
                    </div>
                </div>

                <div class="form-element">
                </div>
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
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-image single">
                    <?php if ($model->image): ?>
                        <img src="/upload/<?= $model->image; ?>">
                    <?php endif; ?>
                </div>
                <?= $form->field($model, 'image')->fileInput(); ?>
            </div>
            <div class="col-sm-6">
                <div class="form-image more">
                    <?php if ($model->images): ?>
                        <?php foreach (Json::decode($model->images) as $image): ?>
                            <img src="<?= $image; ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?= $form->field($model, 'imagesFiles[]')->fileInput([
                    'multiple' => true,
                    'accept' => 'image/*'
                ]); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-additional" role="tabpanel" aria-labelledby="nav-additional-tab">
        <div class="form-element">
            <?= $form->field($model, 'code')->textInput(); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'vitrine')->radioList(["Нет", "Да"]); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'active')->radioList(["Не активен", "Активен"]); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'stock_id')->dropDownList(ArrayHelper::map(Stocks::find()->all(), 'id', 'name')) ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-props" role="tabpanel" aria-labelledby="nav-props-tab">
        <ul style="list-style: none; margin: 0; padding: 0;">
            <?php try { ?>
                <ul style="list-style: none; margin: 0; padding: 0;">
                    <?php foreach ($properties as $property): ?>
                        <?php if ($property->type == 1): ?>
                            <?php $value = ProductPropertiesValues::findAll([
                                'product_id' => $model->id,
                                'property_id' => $property->id
                            ]);
                            if ($value):
                                $model->properties[$property->id] = ArrayHelper::getColumn($value, 'value');
                            endif; ?>
                            <?php
                            $drop_down_params = ['prompt' => $property->name, 'multiple' => (boolean)$property->multiple];
                            if ((boolean)$property->multiple == true) {
                                $drop_down_params['size'] = 10;
                            }
                            ?>
                            <?= $form->field($model, 'properties[' . $property->id . ']')->dropDownList(ArrayHelper::map(InformersValues::find()->where(['informer_id' => $property->informer_id])->orderBy(['created_at' => SORT_DESC])->all(), 'id', 'name'), $drop_down_params)->label($property->name); ?>
                        <?php else: ?>
                            <?php if ($value = ProductPropertiesValues::findOne(['product_id' => $model->id, 'property_id' => $property->id])): ?>
                                <?= $form->field($model, 'properties[' . $property->id . ']')->textInput(['value' => $value->value])->label($property->name); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'properties[' . $property->id . ']')->textInput()->label($property->name); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php } catch (ErrorException $exception) { ?>
                <?= $exception->getMessage(); ?>
                <?= $exception->getLine(); ?>
            <?php } ?>
        </ul>
    </div>
</div>