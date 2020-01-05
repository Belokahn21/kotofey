<?php

/* @var $this yii\web\View */
/* @var $products \app\models\entity\Product */
/* @var $filterModel CatalogFilter */

/* @var $category \app\models\entity\Category */

use app\models\entity\Category;
use app\models\entity\Basket;
use app\models\tool\Currency;
use app\models\tool\seo\Title;
use app\widgets\catalog_filter\CatalogFilterWidget;
use app\models\forms\CatalogFilter;
use yii\widgets\LinkPager;
use app\models\entity\ProductPropertiesValues;
use app\models\helpers\DiscountHelper;

$this->title = Title::showTitle("Товары");
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/catalog/']];
if ($category) {
    foreach ($category->undersections() as $parents) {
        $this->params['breadcrumbs'][] = ['label' => $parents->name, 'url' => ['/catalog/' . $parents->slug . "/"]];
    }
    $this->title = Title::showTitle($category->name);
}
$category_id = 0;
if ($category) {
    $category_id = $category->id;
}


?>
<div class="catalog filtred">

    <?= CatalogFilterWidget::widget(); ?>

    <div class="catalog-wrap">
        <div class="sub-categories-wrap">
            <ul class="sub-categories">
                <?php // TODO: проверить условие исключения родителських категорий ?>
                <?php foreach (Category::find()->where(['parent' => $category_id])->all() as $child): ?>
                    <li class="sub-categories__item">
                        <a class="sub-categories__link" href="<?= $child->detail; ?>">
                            <div class="sub-categories__title"><?= $child->name; ?></div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <ul class="filter-variant">
            <li class="filter-variant__item" data-show="list"><i class="fas fa-list"></i></li>
            <li class="filter-variant__item active" data-show="block"><i class="fas fa-th-large"></i></li>
        </ul>
        <ul class="catalog-list">
            <?php /* @var $product \app\models\entity\Product */ ?>
            <?php foreach ($products as $product): ?>
                <li class="catalog-list__item">

                    <div class="catalog-list__weight"><?= ProductPropertiesValues::findOne(['product_id' => $product->id, 'property_id' => '2'])->value; ?> КГ</div>

                    <a href="<?= $product->detail; ?>" class="catalog-list__link">
                        <?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                            <img class="catalog-list__image" src="/web/upload/<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                        <?php else: ?>
                            <img class="catalog-list__image" src="/web/upload/images/not-image.png" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                        <?php endif; ?>
                    </a>

                    <a href="<?= $product->detail; ?>" class="catalog-list__link">
                        <div class="catalog-list__title"><?= $product->name; ?></div>
                    </a>
                    <div class="catalog-list__group-price">
                        <div class="catalog-list__price">
                            <div class="value"><?= $product->price; ?> <?= Currency::getInstance()->show(); ?></div>
                            <div class="bonus"><?= DiscountHelper::calcBonus($product->price); ?> бонуса</div>
                        </div>

                        <div class="catalog-list__group-cart">
                            <div class="product-button product-add-basket<?= (!Basket::getInstance()->exist($product->id)) ? '' : ' hide'; ?>" data-product="<?= $product->id; ?>">
                                В корзину
                            </div>


                            <div class="product-detail-calc-wrap<?= ((Basket::getInstance()->exist($product->id)) ? '' : ' hide'); ?>">
                                <form class="product-detail-calc-form">

                                    <div class="product-detail-calc-element">
                                        <div class="product-detail-calc-min" data-product="<?= $product->id; ?>">-</div>
                                    </div>

                                    <div class="product-detail-calc-element">
                                        <input type="text" class="product-detail-calc-count" name="count" placeholder="1" value="<?= Basket::findOne($product->id)->getCount(); ?>">
                                    </div>

                                    <div class="product-detail-calc-element">
                                        <div class="product-detail-calc-plus" data-product="<?= $product->id; ?>">+</div>
                                    </div>
                                </form>
                            </div>

                            <ul class="summary">
                                <li class="summary__item available">В наличии</li>
                                <li class="summary__item">Арткиул: <?= $product->article; ?></li>
                            </ul>

                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="pagination-wrap">
    <?php echo LinkPager::widget([
        'pagination' => $pagerItems,
    ]); ?>
</div>

