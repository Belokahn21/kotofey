<?php

/* @var $this yii\web\View
 * @var $products \app\modules\catalog\models\entity\Product
 * @var $filterModel CatalogFilter
 * @var $category \app\modules\catalog\models\entity\Category
 */

use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use app\models\tool\seo\Title;
use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\widgets\filter\CatalogFilterWidget;

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

            <?= CatalogFilterWidget::widget([
                'category' => $category
            ]); ?>

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
            <?php if ($products): ?>
                <ul class="catalog">
                    <?php foreach ($products as $product): ?>
                        <?= $this->render('@app/modules/catalog/views/__item', [
                            'product' => $product
                        ]); ?>
                    <?php endforeach; ?>
                </ul>
                <?= LinkPager::widget([
                    'pagination' => $pagerItems,
                ]); ?>
            <?php else: ?>
                <img src="/upload/images/not-found.png">
            <?php endif; ?>
        </div>
    </div>
</div>


<?php /* $this->render('@app/modules/catalog/views/__item', [
    'product' => $product
]); */ ?>

