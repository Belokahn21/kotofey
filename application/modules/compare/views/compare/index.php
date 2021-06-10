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

<div class="compare-list">
    <div class="compare-list__row">
        <div class="compare-list__col"></div>
        <?php foreach ($models as $product_id => $data): ?>
            <div class="compare-list__col"><?= $data['product']->name; ?></div>
        <?php endforeach; ?>
    </div>

    <?php foreach ($avail_properties as $property_id => $properties_data): ?>
        <div class="compare-list__row">
            <div class="compare-list__col"><?= $properties_data['property']->name; ?></div>
            <?php foreach ($models as $product_id => $data): ?>
                <div class="compare-list__col">
                    <?php $value = PropertiesHelper::extractPropertyById($data['product'], $property_id); ?>
                    <?php if ($value): ?>
                        <?= ProductPropertiesValuesHelper::getFinalValue($value); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>