<?php

use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\models\repository\ProductRepository;
use app\modules\catalog\models\repository\PropertiesProductValuesRepository;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $properties \app\modules\catalog\models\entity\Properties[]
 * @var $form \yii\widgets\ActiveForm
 * @var $this \yii\web\View
 */
?>

<?php
$property_ids = [];
$values = [];
?>

<?php foreach ($properties as $group_id => $data): ?>
    <?php foreach ($data['models'] as $property): ?>
        <?php $property_ids[] = $property->id; ?>
    <?php endforeach; ?>
<?php endforeach; ?>

<?php
$product_id = $model->id;
$sorted_products = ProductRepository::getAllProductsSortedDesc();
if (!$model->isNewRecord) {
    $values = PropertiesProductValuesRepository::collectValues($property_ids, $product_id);
}
?>

<div style="list-style: none; margin: 0; padding: 0;">
    <?php try { ?>
        <div style="list-style: none; margin: 0; padding: 0;">
            <?php foreach ($properties as $group_id => $data): ?>
                <fieldset class="fieldset-props">
                    <legend>
                        <?php if ($group = ArrayHelper::getValue($properties[$group_id], 'group')): ?>
                            <?= $group->name; ?>
                        <?php else: ?>
                            <?= "Без категории"; ?>
                        <?php endif; ?>
                    </legend>
                    <?php foreach ($data['models'] as $property): ?>
                        <?php if ($property->type == TypeProductProperties::TYPE_INFORMER || $property->type == TypeProductProperties::TYPE_CATALOG): ?>
                            <?= $this->render('property/informer', [
                                'form' => $form,
                                'model' => $model,
                                'values' => $values,
                                'property' => $property,
                                'sorted_products' => $sorted_products,
                            ]); ?>
                        <?php elseif ($property->type == TypeProductProperties::TYPE_CHECKBOX): ?>
                            <?= $this->render('property/checkbox', [
                                'form' => $form,
                                'model' => $model,
                                'property' => $property,
                                'values' => $values,
                            ]); ?>
                        <?php elseif ($property->type == TypeProductProperties::TYPE_FILE): ?>
                            <?= $this->render('property/file', [
                                'form' => $form,
                                'model' => $model,
                                'property' => $property,
                                'values' => $values,
                            ]); ?>
                        <?php else: ?>
                            <?= $this->render('property/common', [
                                'form' => $form,
                                'model' => $model,
                                'property' => $property,
                                'values' => $values,
                            ]); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </fieldset>
            <?php endforeach; ?>
        </div>
    <?php } catch (ErrorException $exception) { ?>
        <?= $exception->getMessage(); ?>
        <?= $exception->getLine(); ?>
        <?= $exception->getFile(); ?>
        <?php var_dump($exception->getTraceAsString()); ?>
    <?php } ?>
</div>
