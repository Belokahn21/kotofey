<?php

use yii\helpers\ArrayHelper;

/* @var $values \app\modules\catalog\models\entity\PropertiesProductValues[] */

$resultArray = [];
?>

<?php foreach ($values as $value): ?>
    <?php $resultArray[$value->property->id]['property'] = $value->property; ?>
    <?php $resultArray[$value->property->id]['values'][] = $value; ?>
<?php endforeach; ?>


<?php foreach ($resultArray as $item): ?>
    <fieldset>
        <legend><?= $item['property']->name; ?></legend>
        <?php foreach (array_unique(ArrayHelper::getColumn($item['values'], 'value')) as $value): ?>
            <?= $value; ?>
            <hr>
        <?php endforeach; ?>
    </fieldset>
<?php endforeach; ?>