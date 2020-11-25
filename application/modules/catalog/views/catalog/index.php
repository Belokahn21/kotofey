<?php

/* @var $this yii\web\View
 * @var $products \app\modules\catalog\models\entity\Product
 * @var $filterModel CatalogFilter
 * @var $category \app\modules\catalog\models\entity\Category
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\widgets\Breadcrumbs;
use app\models\tool\seo\Title;
use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\widgets\Sort\ProductSortWidget;
use app\modules\catalog\widgets\filter\CatalogFilterWidget;
use app\modules\catalog\models\helpers\CategoryHelper;

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
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title"><?= ($category ? $category->name : "Каталог товаров"); ?></h1>
    <div class="catalog-container">
        <aside class="left-siderbar">

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
                            <a class="aside-sub-categories__link" href="<?= CategoryHelper::getDetailUrl($category); ?>"><?= $category->name; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?= CatalogFilterWidget::widget([
                'category' => $category
            ]); ?>
        </aside>
        <div class="catalog-wrap">
            <?= ProductSortWidget::widget(); ?>
            <?php if ($products): ?>
                <ul class="catalog">
                    <?php foreach ($products as $product): ?>
                        <?= $this->render('@app/modules/catalog/views/__item', [
                            'product' => $product
                        ]); ?>
                    <?php endforeach; ?>
                </ul>
                <div class="pagination-wrap">
                    <?= LinkPager::widget([
                        'pagination' => $pagerItems,
                    ]); ?>
                </div>
            <?php else: ?>
                <img style="width: 100%;" src="/upload/images/not-found.png">
            <?php endif; ?>
        </div>
    </div>
</div>


<?php /* $this->render('@app/modules/catalog/views/__item', [
    'product' => $product
]); */ ?>

