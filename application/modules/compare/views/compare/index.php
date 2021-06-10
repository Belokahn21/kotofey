<?php

use app\modules\seo\models\tools\Title;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $this \yii\web\View */
/* @var $models array */
/* @var $avail_properties array */

$this->title = Title::show("Сравните выбранные товары");

$this->params['breadcrumbs'][] = ['label' => 'Сравнение твоаров', 'url' => ['site/compare']];
?>
<h1>Сравнение товаров</h1>

<table border="1" width="100%">
    <tr>
        <td></td>
        <?php foreach ($models as $product_id => $data): ?>
            <td><?= $data['product']->name; ?></td>
        <?php endforeach; ?>
    </tr>

    <?php foreach ($avail_properties as $property_id => $properties_data): ?>
        <tr>
            <td><?= $properties_data['property']->name; ?></td>
            <?php foreach ($models as $product_id => $data): ?>
                <td>
                    <?php $value = PropertiesHelper::extractPropertyById($data['product'], $property_id); ?>
                    <?php if ($value): ?>
                        <?= ProductPropertiesValuesHelper::getFinalValue($value); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>