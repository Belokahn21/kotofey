<?php

use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $property \app\modules\catalog\models\entity\Properties */
/* @var $values PropertiesProductValues[] */


?>
<?php if (!$model->isNewRecord && $value = ProductPropertiesValuesHelper::getValue($values, $property->id, $model->id)): ?>
    <?= $form->field($model, 'properties[' . $property->id . ']')->textInput(['value' => $value])->label($property->name); ?>
<?php else: ?>
    <?= $form->field($model, 'properties[' . $property->id . ']')->textInput()->label($property->name); ?>
<?php endif; ?>

