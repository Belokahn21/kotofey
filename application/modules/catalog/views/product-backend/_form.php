<?php

use app\modules\catalog\models\entity\ProductOrder;
use app\modules\stock\models\entity\Stocks;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Category;
use yii\helpers\Json;
use app\modules\vendors\models\entity\Vendor;
use app\modules\site\models\helpers\ProductMarkupHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\media\widgets\InputUploadWidget\InputUploadWidget;
use app\modules\media\models\entity\Media;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\PropertyGroup;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 * @var $properties \app\modules\catalog\models\entity\Properties[]
 */

?>
<?php //= FillFromVendorWidget::widget(); ?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
        <a class="nav-item nav-link" id="nav-additional-tab" data-toggle="tab" href="#nav-additional" role="tab" aria-controls="nav-additional" aria-selected="false">Условия доставки</a>
        <a class="nav-item nav-link" id="nav-props-tab" data-toggle="tab" href="#nav-props" role="tab" aria-controls="nav-props" aria-selected="false">Свойства</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-element">
                    <?= $form->field($model, 'status_id')->dropDownList($model->getStatusList(), ['prompt' => 'Статус товара'])->label(false); ?>
                </div>
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

                    <div class="col-sm-3 set-price-container">
                        <div class="form-element">
                            <?= $form->field($model, 'price')->textInput(['id' => 'id-price', 'placeholder' => 'Цена продажи'])->label(false); ?>
                        </div>

                        <div class="set-price">
                            <input class="set-price__input" placeholder="<?= ProductMarkupHelper::getProductMarkupFromCookie() ?>" value="<?= ProductMarkupHelper::getProductMarkupFromCookie(); ?>">
                            <a href="javascript:void(0);" class="set-price__action">
                                <img src="/upload/images/percentage.png">
                            </a>
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

                <div class="form-element">
                    <?= $form->field($model, 'code')->textInput(['placeholder' => 'Внешний код'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'barcode')->textInput(['placeholder' => 'Штрих-код'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'vitrine')->radioList(["Нет", "Да"]); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'is_ali')->radioList(["Нет", "Да"]); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'stock_id')->dropDownList(ArrayHelper::map(Stocks::find()->all(), 'id', 'name')) ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'threeDCode')->textarea(['rows' => 5]) ?>
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
                    <?php if ($model->media): ?>
                        <?php if ($model->media->location == Media::LOCATION_SERVER): ?>
                            <a target="_blank" href="<?= ProductHelper::getImageUrl($model) ?>">
                                <img src="<?= ProductHelper::getImageUrl($model) ?>" width="150" title="<?= $model->name; ?>" alt="<?= $model->name; ?>">
                            </a>
                            <br>
                            Размер: <?= Yii::$app->formatter->asShortSize(filesize(Yii::getAlias('@webroot' . ProductHelper::getImageUrl($model)))); ?>
                        <?php else: ?>
                            <img src="<?= ProductHelper::getImageUrl($model) ?>" width="150" title="<?= $model->name; ?>" alt="<?= $model->name; ?>">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?= $form->field($model, 'image')->widget(InputUploadWidget::className(), [
                    'dopAttr' => 'media_id'
                ]); ?>
            </div>
            <div class="col-sm-6">
                <div class="form-image more">
                    <?php if ($model->images): ?>
                        <?php foreach (Json::decode($model->images) as $image): ?>
                            <img src="<?= $image; ?>" width="150">
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

    </div>
    <div class="tab-pane fade" id="nav-props" role="tabpanel" aria-labelledby="nav-props-tab">
        <ul style="list-style: none; margin: 0; padding: 0;">
            <?php try { ?>
                <ul style="list-style: none; margin: 0; padding: 0;">
                    <?php foreach ($properties as $group_id => $props): ?>
                        <fieldset class="fieldset-props">
                            <legend>
                                <?php
                                $group = PropertyGroup::findOne($group_id);
                                if ($group) echo $group->name;
                                ?>
                            </legend>
                            <?php foreach ($props as $property): ?>
                                <?php if ($property->type == 1): ?>
                                    <?php $value = PropertiesProductValues::findAll([
                                        'product_id' => $model->id,
                                        'property_id' => $property->id
                                    ]);
                                    if ($value):
                                        $model->properties[$property->id] = ArrayHelper::getColumn($value, 'value');
                                    endif; ?>
                                    <?php
                                    $drop_down_params = ['prompt' => $property->name, 'multiple' => (boolean)$property->is_multiple];
                                    if ((boolean)$property->is_multiple == true) {
                                        $drop_down_params['size'] = 10;
                                    }
                                    ?>
                                    <?= $form->field($model, 'properties[' . $property->id . ']')->dropDownList(ArrayHelper::map(PropertiesVariants::find()->where(['property_id' => $property->id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), $drop_down_params)->label($property->name); ?>
                                <?php else: ?>
                                    <?php if ($value = PropertiesProductValues::findOne(['product_id' => $model->id, 'property_id' => $property->id])): ?>
                                        <?= $form->field($model, 'properties[' . $property->id . ']')->textInput(['value' => $value->value])->label($property->name); ?>
                                    <?php else: ?>
                                        <?= $form->field($model, 'properties[' . $property->id . ']')->textInput()->label($property->name); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </fieldset>
                    <?php endforeach; ?>
                </ul>
            <?php } catch (ErrorException $exception) { ?>
                <?= $exception->getMessage(); ?>
                <?= $exception->getLine(); ?>
            <?php } ?>
        </ul>
    </div>
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