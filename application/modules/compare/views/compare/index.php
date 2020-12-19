<?php

use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\compare\models\entity\Compare;
use app\models\tool\seo\Title;

/* @var $this \yii\web\View */

$this->title = Title::showTitle("Сравните выбранные товары");

$this->params['breadcrumbs'][] = ['label' => 'Сравнение твоаров', 'url' => ['site/compare']];
?>
<h1>Сравнение товаров</h1>
<ul class="compare-list">
	<?php foreach (Compare::findAll() as $item): ?>
        <li class="compare-list__item">
            <img src="/upload/<?= $item->image; ?>" class="compare-list__image">
            <div class="compare-list__title"><?= $item->name; ?></div>

            <ul class="compare-properties">
				<?php foreach (SaveProductPropertiesValues::find()->where(['product_id' => $item->id])->all() as $property_value): ?>
                    <li class="compare-properties__item <?php // identity ?>">
                        <div class="compare-properties__key"><?= $property_value->property->name; ?></div>
                        <div class="compare-properties__value"><?= $property_value->finalValue; ?></div>
                    </li>
				<?php endforeach; ?>
            </ul>
        </li>
	<?php endforeach; ?>
</ul>