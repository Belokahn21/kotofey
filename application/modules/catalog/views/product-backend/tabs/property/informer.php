<?php

use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\models\repository\PropertiesVariantsRepository;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $property \app\modules\catalog\models\entity\Properties */


$value = false;
$variants = [];
$drop_down_params = [
    'prompt' => $property->name,
    'multiple' => (boolean)$property->is_multiple,
    'class' => 'js-select2-element'
];

if (!$model->isNewRecord && $value = ProductPropertiesValuesHelper::getValues($values, $property->id, $model->id)) {
    $model->properties[$property->id] = ArrayHelper::getColumn($value, 'value');
}

if ((boolean)$property->is_multiple == true) {
    $drop_down_params['size'] = 10;
}


if ($property->type == TypeProductProperties::TYPE_CATALOG) {
    $variants = ArrayHelper::map($sorted_products, 'id', 'name');
    array_walk($variants, function (&$value, $key) {
        $value = $key . ' - ' . $value;
    });
} else {
    $variants = ArrayHelper::map(PropertiesVariantsRepository::variantsByPropertyId($property->id), 'id', 'name');
}
?>

<?php /* = $form->field($model, 'properties[' . $property->id . '][]')->widget(\kartik\select2\Select2::classname(), [
    'data' => $variants,
    'options' => $drop_down_params,
    'hashVarLoadPosition' => \yii\web\View::POS_END
])->label($property->name); */ ?>

<?= $form->field($model, 'properties[' . $property->id . '][]')->dropDownList($variants, $drop_down_params)->label($property->name); ?>
