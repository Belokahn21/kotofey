<?php

use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $property \app\modules\catalog\models\entity\Properties */
/* @var $values PropertiesProductValues[] */
/* @var $this \yii\web\View */
?>

<?php $params = []; ?>
<?php if (!$model->isNewRecord && $value = ProductPropertiesValuesHelper::getValue($values, $property->id, $model->id)): ?>
    <?php $params['value'] = $value; ?>
<?php endif; ?>

<?= $form->field($model, 'properties[' . $property->id . ']')->textInput($params)->label($property->name); ?>
