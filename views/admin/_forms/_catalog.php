<?php

use app\models\entity\SiteSettings;
use app\models\entity\Stocks;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\ProductPropertiesValues;
use yii\helpers\Json;

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
        <li class="tab-link" data-tab="tab-2">SEO</li>
        <li class="tab-link" data-tab="tab-3">Галлерея</li>
        <li class="tab-link" data-tab="tab-4">Дополнительно</li>
        <li class="tab-link" data-tab="tab-5">Свойства</li>
    </ul>

    <div id="tab-1" class="tab-content current">
		<?= $form->field($model, 'name'); ?>
		<?= $form->field($model, 'description')->textarea(); ?>
        <div class="product-form__price">
			<?= $form->field($model, 'price')->textInput(['id' => 'id-price']); ?>
            <div class="set-price">
                <a href="" onclick="document.getElementById('id-price').value=(parseInt(document.getElementById('id-purchase').value)+parseInt((document.getElementById('id-purchase').value*<?= SiteSettings::getValueByCode('saleup') ?>)/100)); return false;">% наценка</a>
            </div>
        </div>
        <div class="product-form__purchase">
			<?= $form->field($model, 'purchase')->textInput(['id' => 'id-purchase']); ?>
        </div>
        <div class="product-form__count">
			<?= $form->field($model, 'count'); ?>
        </div>
        <div class="clearfix"></div>
		<?= $form->field($model, 'category')->dropDownList(ArrayHelper::map((new Category())->categoryTree(), 'id', 'name'), ['prompt' => 'Раздел']); ?>
        <div class="clearfix"></div>
        <hr/>
    </div>
    <div id="tab-2" class="tab-content">
		<?= $form->field($model, 'seo_description')->textarea(); ?>
		<?= $form->field($model, 'seo_keywords'); ?>
    </div>
    <div id="tab-3" class="tab-content">
        <div class="product-form__simple-image">
			<?php if ($model->image): ?>
                <img src="/web/upload/<?= $model->image; ?>" width="200">
			<?php endif; ?>
			<?= $form->field($model, 'image')->fileInput(); ?>
        </div>
        <div class="product-form__more-image">
			<?php if ($model->images): ?>
				<?php foreach (Json::decode($model->images) as $image): ?>
                    <img src="/web/upload/<?= $image; ?>" width="200">
				<?php endforeach; ?>
			<?php endif; ?>
			<?= $form->field($model, 'imagesFiles[]')->fileInput([
				'multiple' => true,
				'accept' => 'image/*'
			]); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="tab-4" class="tab-content">
        <div class="left-col">
			<?= $form->field($model, 'code')->textInput(); ?>
			<?= $form->field($model, 'vitrine')->radioList(["Нет", "Да"]); ?>
			<?= $form->field($model, 'active')->radioList(["Не активен", "Активен"]); ?>
			<?= $form->field($model, 'stock_id')->dropDownList(ArrayHelper::map(Stocks::find()->all(), 'id', 'name')) ?>
        </div>
        <div class="right-col">
			<?= $form->field($model, 'has_store')->checkbox(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="tab-5" class="tab-content">
        <ul style="list-style: none; margin: 0; padding: 0;">
			<? /* @var $property \app\models\entity\ProductProperties */ ?>
			<?php try { ?>
                <ul style="list-style: none; margin: 0; padding: 0;">
					<? foreach ($properties as $property): ?>
						<? if ($property->type == 1): ?>
							<?php $value = ProductPropertiesValues::findOne([
								'product_id' => $model->id,
								'property_id' => $property->id
							]);
							if ($value):
								$model->properties[$property->id] = $value->value;
							endif; ?>
							<?= $form->field($model, 'properties[' . $property->id . ']')->dropDownList(ArrayHelper::map(InformersValues::find()->where(['informer_id' => $property->informer_id])->all(), 'id', 'name'), ['prompt' => $property->name])->label($property->name); ?>
						<? else: ?>
							<?= $form->field($model, 'properties[' . $property->id . ']')->textInput(['value' => ProductPropertiesValues::findOne(['product_id' => $model->id, 'property_id' => $property->id])->value])->label($property->name); ?>
						<? endif; ?>
					<? endforeach; ?>
                </ul>
			<?php } catch (ErrorException $exception) { ?>
				<?= $exception->getMessage(); ?>
			<?php } ?>
        </ul>
    </div>
</div>