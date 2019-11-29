<?php

use app\models\entity\ProductOrder;
use app\models\entity\SiteSettings;
use app\models\entity\Stocks;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\ProductPropertiesValues;
use yii\helpers\Json;

/* @var $model \app\models\entity\Product */
/* @var $modelDelivery \app\models\entity\ProductOrder */

?>


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
					<?= $form->field($model, 'category')->dropDownList(ArrayHelper::map((new Category())->categoryTree(), 'id', 'name'), ['prompt' => 'Раздел товара'])->label(false); ?>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-element">
							<?= $form->field($model, 'purchase')->textInput(['id' => 'id-purchase', 'placeholder' => 'Закупочная цена'])->label(false); ?>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-element">
							<?= $form->field($model, 'price')->textInput(['id' => 'id-price', 'placeholder' => 'Цена продажи'])->label(false); ?>
                        </div>

                        <div class="set-price">
                            <a href="" onclick="document.getElementById('id-price').value=(parseInt(document.getElementById('id-purchase').value)+parseInt((document.getElementById('id-purchase').value*<?= SiteSettings::getValueByCode('saleup') ?>)/100)); return false;">% наценка</a>
                        </div>
                    </div>

                    <div class="col-sm-4">
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
    </div>
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-image single">
					<?php if ($model->image): ?>
                        <img src="/web/upload/<?= $model->image; ?>">
					<?php endif; ?>
                </div>
				<?= $form->field($model, 'image')->fileInput(); ?>
            </div>
            <div class="col-sm-6">
                <div class="form-image more">
					<?php if ($model->images): ?>
						<?php foreach (Json::decode($model->images) as $image): ?>
                            <img src="/web/upload/<?= $image; ?>">
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
			<?php /* @var $property \app\models\entity\ProductProperties */ ?>
			<?php try { ?>
                <ul style="list-style: none; margin: 0; padding: 0;">
					<?php foreach ($properties as $property): ?>
						<?php if ($property->type == 1): ?>
							<?php $value = ProductPropertiesValues::findOne([
								'product_id' => $model->id,
								'property_id' => $property->id
							]);
							if ($value):
								$model->properties[$property->id] = $value->value;
							endif; ?>
							<?= $form->field($model, 'properties[' . $property->id . ']')->dropDownList(ArrayHelper::map(InformersValues::find()->where(['informer_id' => $property->informer_id])->orderBy(['created_at' => SORT_DESC])->all(), 'id', 'name'), ['prompt' => $property->name])->label($property->name); ?>
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