<?php

use app\models\entity\Compare;
use app\models\tool\seo\Title;

/* @var $this \yii\web\View */

$this->title = Title::showTitle("Сравните выбранные товары");
?>
<h1>Сравнение товаров</h1>
<ul class="compare-list">
	<?php foreach (Compare::findAll() as $item): ?>
        <li class="compare-list__item">
            <img src="/web/upload/<?= $item->image; ?>" class="compare-list__image">
            <div class="compare-list__title"><?= $item->name; ?></div>

            <ul class="compare-properties">
                <li class="compare-properties__item identity">
                    <div class="compare-properties__key">Количество</div>
                    <div class="compare-properties__value">10</div>
                </li>
                <li class="compare-properties__item">
                    <div class="compare-properties__key">Вес</div>
                    <div class="compare-properties__value">10 кг</div>
                </li>
                <li class="compare-properties__item">
                    <div class="compare-properties__key">Производитель</div>
                    <div class="compare-properties__value">Пурина</div>
                </li>
                <li class="compare-properties__item">
                    <div class="compare-properties__key">Страна</div>
                    <div class="compare-properties__value">Австрия</div>
                </li>
            </ul>
        </li>
	<?php endforeach; ?>
</ul>