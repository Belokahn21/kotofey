<?php

use yii\helpers\Url;

/* @var $sort array
 * @var $display array
 */

?>
<form class="catalog-sort">
    <?php /*
    <input class="catalog-sort__input" id="catalog-sort-variant-1" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-1">
        <div class="catalog-sort__title">Строительный</div>
    </label><input class="catalog-sort__input" id="catalog-sort-variant-2" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-2">
        <div class="catalog-sort__title">Ручной</div>
    </label><input class="catalog-sort__input" id="catalog-sort-variant-3" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-3">
        <div class="catalog-sort__title">Печной</div>
    </label><input class="catalog-sort__input" id="catalog-sort-variant-4" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-4">
        <div class="catalog-sort__title">Силикатный</div>
    </label>
 */ ?>

    <div class="type-display">
        <?php foreach ($display as $value => $class): ?>
            <a class="type-display__item<?= $value == Yii::$app->request->get('display', 'block') ? ' active' : ''; ?> " href="<?= Url::current(['display' => $value]); ?>">
                <i class="<?= $class; ?>"></i>
            </a>
        <?php endforeach; ?>
    </div>


    <?php if ($sort): ?>
        <div class="catalog-sort-select">
            <label class="catalog-sort-select__label" for="catalog-sort-selector">Сортировать</label>
            <select class="catalog-sort-select__select js-selectize" id="catalog-sort-selector">
                <?php foreach ($sort as $item): ?>
                    <?php $selected = Yii::$app->request->get($item['key']) == $item['value'] ? "selected" : ""; ?>
                    <option <?= $selected; ?> value="<?= $item['value'] ?>"><?= $item['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
</form>