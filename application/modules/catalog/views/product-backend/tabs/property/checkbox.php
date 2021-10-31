<?php

use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $property \app\modules\catalog\models\entity\Properties */
?>

<?php if ($value = ProductPropertiesValuesHelper::getValue($values, $property->id, $model->id)): ?>
    <?= $form->field($model, 'properties[' . $property->id . ']')->checkbox(['value' => $value->value, 'checked' => true])->label($property->name); ?>
<?php else: ?>
    <?= $form->field($model, 'properties[' . $property->id . ']')->checkbox()->label($property->name); ?>
<?php endif; ?>