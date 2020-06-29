<?php

/* @var $this yii\web\View */
/* @var $products \app\modules\catalog\models\entity\Product */
/* @var $filterModel CatalogFilter */

/* @var $category \app\modules\catalog\models\entity\Category */

use app\models\tool\seo\Title;
use app\widgets\catalog_filter\CatalogFilterWidget;
use app\models\forms\CatalogFilter;
use yii\widgets\LinkPager;
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
<div class="catalog filtred">

    <?= CatalogFilterWidget::widget([
        'category' => $category
    ]); ?>

    <div class="catalog-wrap">
        <div class="sub-categories-wrap">
            <ul class="sub-categories">
                <?php foreach (Category::find()->where(['parent' => $category_id])->all() as $child): ?>
                    <li class="sub-categories__item">
                        <a class="sub-categories__link" href="<?= $child->detail; ?>">
                            <div class="sub-categories__title"><?= $child->name; ?></div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="filter-variant__wrap">
            <h1 class="catalog__title"><?= ($category ? (!empty($category->seo_title) ? $category->seo_title : $category->name) : 'Каталог зоотоваров'); ?></h1>
            <ul class="filter-variant">
                <li class="filter-variant__item" data-show="list"><i class="fas fa-list"></i></li>
                <li class="filter-variant__item active" data-show="block"><i class="fas fa-th-large"></i></li>
            </ul>
        </div>
        <ul class="catalog-list">
            <?php /* @var $product \app\modules\catalog\models\entity\Product */ ?>
            <?php foreach ($products as $product): ?>

                <?= $this->render('@app/modules/catalog/views/__item', [
                    'product' => $product
                ]); ?>

            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="pagination-wrap">
    <?php echo LinkPager::widget([
        'pagination' => $pagerItems,
    ]); ?>
</div>

