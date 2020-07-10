<?php

/* @var $this yii\web\View
 * @var $products \app\modules\catalog\models\entity\Product
 * @var $filterModel CatalogFilter
 * @var $category \app\modules\catalog\models\entity\Category
 */

use yii\widgets\LinkPager;
use app\models\tool\seo\Title;
use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Category;

$this->title = Title::showTitle("Зоотовары");
$category_id = 0;
$this->params['breadcrumbs'][] = ['label' => 'Зоотовары', 'url' => ['/catalog/']];


if ($category) {
    foreach ($category->undersections() as $parents) {
        $this->params['breadcrumbs'][] = ['label' => $parents->name, 'url' => ['/catalog/' . $parents->slug . "/"]];
    }

    // set title
    $category_id = $category->id;
    $this->title = Title::showTitle($category->name);
    if ($category->seo_title) {
        $this->title = Title::showTitle($category->seo_title);
    }
} ?>
<div class="page">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Кирпичи</a></li>
    </ul>
    <h1 class="page__title"><?= ($category ? $category->name : "Каталог товаров"); ?></h1>
    <div class="catalog-container">
        <aside class="left-siderbar">
            <form class="filter-catalog">
                <div class="filter-catalog__title"><span>Подобрать товар</span><span class="filter-catalog__arrow is-active"><img src="/upload/images/arrow-left-black.svg"></span></div>
                <div class="filter-catalog-container is-active">
                    <div class="filter-catalog__item"><label class="filter-catalog__label" for="js-filter-from">Цена</label>
                        <div class="filter-catalog__input-group"><input class="filter-catalog__input" id="js-filter-from" placeholder="100" type="text"><input class="filter-catalog__input" id="js-filter-to" placeholder="999" type="text"></div>
                    </div>
                    <div class="filter-catalog__item"><input class="filter-catalog__range" type="range"></div>
                    <div class="filter-catalog__item"><label class="filter-catalog__label" for="js-filter-from">Бренд</label>
                        <ul class="filter-catalog-checkboxes">
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Bergauf</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Ceresit</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Dauer</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Holcim</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Unis</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Волма</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Стройбриг</li>
                            <li class="filter-catalog-checkboxes__item"><input type="checkbox" name="brand">Русеан</li>
                        </ul>
                    </div>
                </div>
                <div class="filter-catalog__button-group">
                    <button class="filter-catalog__submit" type="submit">Показать</button>
                    <button class="filter-catalog__reset" type="reset"><span class="filter-catalog__reset-icon"><img src="/upload/images/reset.png"></span><span>Сбросить</span></button>
                </div>
            </form>

            <?php if ($category): ?>
                <?php $id = $category->id; ?>
            <?php else: ?>
                <?php $id = 0; ?>
            <?php endif; ?>

            <?php $subCategories = Category::find()->where(['parent' => $id])->all(); ?>

            <?php if ($subCategories): ?>
                <ul class="aside-sub-categories">
                    <?php foreach ($subCategories as $category): ?>
                        <li class="aside-sub-categories__item">
                            <a class="aside-sub-categories__link" href="<?= $category->detail; ?>"><?= $category->name; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>
        <div class="catalog-wrap">
            <form class="catalog-sort"><input class="catalog-sort__input" id="catalog-sort-variant-1" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-1">
                    <div class="catalog-sort__title">Строительный</div>
                </label><input class="catalog-sort__input" id="catalog-sort-variant-2" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-2">
                    <div class="catalog-sort__title">Ручной</div>
                </label><input class="catalog-sort__input" id="catalog-sort-variant-3" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-3">
                    <div class="catalog-sort__title">Печной</div>
                </label><input class="catalog-sort__input" id="catalog-sort-variant-4" type="checkbox" name="sort-checkbox"><label class="catalog-sort__item checkbox-type" for="catalog-sort-variant-4">
                    <div class="catalog-sort__title">Силикатный</div>
                </label>
                <div class="catalog-sort-select"><label class="catalog-sort-select__label" for="catalog-sort-selector">Сортировать</label><select class="catalog-sort-select__select js-selectize" id="catalog-sort-selector">
                        <option>Сначала дешевые</option>
                        <option>Сначала дорогие</option>
                    </select></div>
            </form>
            <ul class="catalog">
                <?php foreach ($products as $product): ?>
                    <?= $this->render('@app/modules/catalog/views/__item', [
                        'product' => $product
                    ]); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?= LinkPager::widget([
    'pagination' => $pagerItems,
]); ?>

<?php /* $this->render('@app/modules/catalog/views/__item', [
    'product' => $product
]); */ ?>

