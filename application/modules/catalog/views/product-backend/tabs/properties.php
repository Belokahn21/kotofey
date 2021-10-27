<?php

use app\modules\catalog\models\entity\Product;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\PropertyGroup;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\models\repository\ProductRepository;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\repository\PropertiesVariantsRepository;
use app\modules\catalog\models\repository\PropertiesProductValuesRepository;
use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 * @var $properties \app\modules\catalog\models\entity\Properties[]
 * @var $form \yii\widgets\ActiveForm
 * @var $prices \app\modules\catalog\models\entity\Price[]
 * @var $compositions \app\modules\catalog\models\entity\Composition[]
 * @var $animals \app\modules\pets\models\entity\Animal[]
 * @var $breeds \app\modules\pets\models\entity\Breed[]
 * @var $this \yii\web\View
 */
?>
<div style="list-style: none; margin: 0; padding: 0;">
    <?php try { ?>
        <div style="list-style: none; margin: 0; padding: 0;">
            <?php foreach ($properties as $group_id => $data): ?>
                <fieldset class="fieldset-props">
                    <legend>
                        <?php
                        if ($group = ArrayHelper::getValue($properties[$group_id], 'group')) echo $group->name;
                        else echo "Без категории";
                        ?>
                    </legend>
                    <?php foreach ($data['properties'] as $property): ?>

                        <?php /* @var $property \app\modules\catalog\models\entity\Properties */ ?>
                        <?php if ($property->type == TypeProductProperties::TYPE_INFORMER || $property->type == TypeProductProperties::TYPE_CATALOG): ?>
                            <?php $value = PropertiesProductValuesRepository::getAllValues($model->id, $property->id);

                            if ($value) $model->properties[$property->id] = ArrayHelper::getColumn($value, 'value');

                            $drop_down_params = ['prompt' => $property->name, 'multiple' => (boolean)$property->is_multiple];
                            if ((boolean)$property->is_multiple == true) $drop_down_params['size'] = 10;

                            $variants = [];

                            if ($property->type == TypeProductProperties::TYPE_CATALOG) {
                                $variants = ArrayHelper::map(Product::find()->select(['id', 'name'])->orderBy(['created_at' => SORT_DESC])->all(), 'id', 'name');
                                array_walk($variants, function (&$value, $key) {
                                    $value = $key . ' - ' . $value;
                                });
                            } else $variants = ArrayHelper::map(PropertiesVariantsRepository::getVariantsByPropertyId($property->id), 'id', 'name'); ?>
                            <?= $form->field($model, 'properties[' . $property->id . '][]')->widget(\kartik\select2\Select2::classname(), [
                                'data' => $variants,
                                'options' => $drop_down_params,
                            ])->label($property->name); ?>
                        <?php elseif ($property->type == TypeProductProperties::TYPE_CHECKBOX): ?>

                            <?php $value = PropertiesProductValuesRepository::getOneValue($model->id, $property->id); ?>

                            <?php if ($value): ?>
                                <?= $form->field($model, 'properties[' . $property->id . ']')->checkbox(['value' => $value->value, 'checked' => true])->label($property->name); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'properties[' . $property->id . ']')->checkbox()->label($property->name); ?>
                            <?php endif; ?>


                        <?php elseif ($property->type == TypeProductProperties::TYPE_FILE): ?>
                            <?= $form->field($model, 'properties[' . $property->id . '][]')->widget(MediaBrowserWidget::className(), [
                                'values' => ArrayHelper::getColumn(ArrayHelper::getColumn(PropertiesProductValuesRepository::getAllValues($model->id, $property->id), 'media'), 'id'),
                                'is_multiple' => true
                            ])->label($property->name); ?>
                        <?php else: ?>
                            <?php if ($value = PropertiesProductValuesRepository::getOneValue($model->id, $property->id)): ?>
                                <?= $form->field($model, 'properties[' . $property->id . ']')->textInput(['value' => $value->value])->label($property->name); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'properties[' . $property->id . ']')->textInput()->label($property->name); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </fieldset>
            <?php endforeach; ?>
        </div>
    <?php } catch (ErrorException $exception) { ?>
        <?= $exception->getMessage(); ?>
        <?= $exception->getLine(); ?>
    <?php } ?>
</div>