<?php

use app\modules\bonus\models\helper\DiscountHelper;
use app\widgets\product_reviews\ProductReviewsWidget;
use app\modules\basket\models\entity\Basket;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\widgets\fast_buy\FastBuyWidget;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\favorite\models\entity\Favorite;
use yii\helpers\Json;
use app\modules\catalog\models\entity\ProductOrder;
use app\modules\catalog\models\entity\Product;
use app\modules\bonus\models\services\BonusByBuyService;

/* @var $properties \app\modules\catalog\models\entity\ProductPropertiesValues[]
 * @var \yii\web\View $this
 * @var \app\modules\catalog\models\entity\Product $product
 * @var \app\modules\catalog\models\entity\Category $category
 */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if ($category) {
    foreach ($category->undersections() as $parents) {
        $this->params['breadcrumbs'][] = ['label' => $parents->name, 'url' => ['/catalog/' . $parents->slug . "/"]];
    }
}
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => [$product->detail]];

$this->title = Title::showTitle($product->name);

?>
<div class="product-detail">
    <div class="product-detail-left">
        <div class="product-detail-gallery">
            <a class="product-detail-gallery__link" href="<?= ProductHelper::getImageUrl($product); ?>" data-lightbox="roadtrip">
                <img class="product-detail-gallery__image" src="<?= ProductHelper::getImageUrl($product); ?>" title="<?= $product->name; ?>" alt="<?= $product->name; ?>">
            </a>
            <div class="product-detail-gallery__group">
                <?php \app\models\tool\Debug::p($product->images); ?>
                <?php if ($product->images): ?>
                    <?php foreach ($product->images as $image): ?>
                        <a class="product-detail-gallery__link active" href="/upload/images/product.png" data-lightbox="roadtrip">
                            <img class="product-detail-gallery__image" src="/upload/images/product.png">
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="product-detail-right">
        <ul class="breadcrumbs">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
            <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Каталог товаров</a></li>
        </ul>
        <h1 class="product-detail__title"><?= $product->name; ?></h1>
        <form class="product-calc js-product-calc">
            <div class="product-calc__price-group">
                <div class="product-calc__price-group-price js-product-calc-price" data-js-product-calc-price="<?= $product->price; ?>"><?= Price::format($product->price); ?></div>
                <div class="product-calc__price-group-char-val">шт</div>
                <div class="product-calc__price-group-char-equal">=</div>
                <div class="product-calc__price-group-summary js-product-calc-summary">
                    <div class="count"><?= Price::format($product->price); ?></div>
                </div>
                <div class="product-calc__price-group-currency">₽</div>
            </div>
            <div class="product-calc__control-group">
                <div class="div">
                    <button class="product-calc__control product-calc__minus js-product-calc-minus" type="button">-</button>
                    <input class="product-calc__count js-product-calc-amount" value="1">
                    <button class="product-calc__control product-calc__plus js-product-calc-plus" type="button">+</button>
                </div>
                <button class="undefined add-basket js-add-basket" type="button">
                    <img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span>
                </button>
                <a class="one-click-buy" href="javascript:void(0);"><span>В один клик</span></a></div>
        </form>
        <?php if ($properties): ?>
            <ul class="product-properties">
                <?php foreach ($properties as $property): ?>
                    <li class="product-properties__line">
                        <div class="product-properties__key"><?= $property->property->name; ?></div>
                        <div class="product-properties__value"><?= $property->finalValue; ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php /*
        <ul class="collapse product-properties" id="collapseExample">
            <li class="product-properties__line">
                <div class="product-properties__key">Артикул товара</div>
                <div class="product-properties__value">0525052</div>
            </li>
        </ul>
        <a class="product-properties__more" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Все характеристики</a>
 */ ?>

        <nav class="product-tabs in-product">
            <div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Описание</a><a class="nav-item nav-link" id="nav-characteristics-tab" data-toggle="tab" href="#nav-characteristics" role="tab" aria-controls="nav-characteristics" aria-selected="false">Характеристики</a><a class="nav-item nav-link" id="nav-recommendations-tab" data-toggle="tab" href="#nav-recommendations" role="tab" aria-controls="nav-recommendations" aria-selected="false">Рекомендации</a></div>
        </nav>
        <div class="tab-content product-tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                <?= $product->description; ?>
            </div>
            <div class="tab-pane fade" id="nav-characteristics" role="tabpanel" aria-labelledby="nav-characteristics-tab">
                Отсутсвует
            </div>
            <div class="tab-pane fade" id="nav-recommendations" role="tabpanel" aria-labelledby="nav-recommendations-tab">
                Отсутсвует
            </div>
        </div>
    </div>
</div>

<?php /*
<div class="page-title__group is-column"><h2 class="page-title">Выгодные предложения</h2><a class="page-title__link" href="javascript:void(0);">Все предложения</a></div>
<div class="swiper-container vitrine-container">
    <div class="swiper-wrapper vitrine-wrapper">
        <div class="swiper-slide vitrine__slide">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick1.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
        <div class="swiper-slide vitrine__slide">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick2.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
        <div class="swiper-slide vitrine__slide active">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick3.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
        <div class="swiper-slide vitrine__slide">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick4.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>
 */ ?>
