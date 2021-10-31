<?php

use yii\helpers\ArrayHelper;
use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $property \app\modules\catalog\models\entity\Properties */


$params = [
    'is_multiple' => true
];

if (!$model->isNewRecord) {
    $params['values'] = ArrayHelper::getColumn(ArrayHelper::getColumn(ProductPropertiesValuesHelper::getValues($values, $property->id, $model->id), 'media'), 'id');
}

?>
<?= $form->field($model, 'properties[' . $property->id . '][]')->widget(MediaBrowserWidget::className(), $params)->label($property->name); ?>