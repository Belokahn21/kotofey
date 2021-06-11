<?php

use app\modules\site\models\tools\Price;
use app\modules\basket\models\entity\Basket;
use app\modules\site\models\tools\Currency;
use app\modules\basket\models\tools\BasketHelper;
use app\modules\compare\models\helpers\CompareHelper;

/* @var $product_id integer
 * @var $showButton boolean
 * @var $price integer
 * @var $discount_price integer
 * @var $discount integer
 * @var $showInfo boolean
 * @var $showControl boolean
 * @var $showOneClick boolean
 * @var $showPrice boolean
 * @var $showCompare boolean
 * @var $basket Basket
 */
$resultPrice = $discount_price ?: $price;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <form class="product-calc js-product-calc">
        <input type="hidden" readonly name="product_id" value="<?= $product_id; ?>">
        <?php if ($showInfo): ?>
            <div class="product-calc__price-group">
                <meta itemprop="price" content="<?= $price ?>">
                <meta itemprop="priceCurrency" content="RUB">
                <link itemprop="availability" href="http://schema.org/InStock">
                <div class="product-calc__discount-unit">
                    <?php if ($discount_price): ?>
                        <div class="product-calc__price-group-price __old"><?= Price::format($price); ?></div>
                        <div class="product-calc__price-group-price __discount"><?= Price::format($discount_price); ?></div>
                    <?php else: ?>
                        <div class="product-calc__price-group-price"><?= Price::format($price); ?></div>
                    <?php endif; ?>
                </div>
                <div class="product-calc__price-group-char-val">шт</div>
                <div class="product-calc__price-group-char-equal">=</div>
                <div class="product-calc__price-group-summary js-product-calc-summary">
                    <div class="count"><?= Price::format($resultPrice * ($basket->count ? $basket->count : 1)); ?></div>
                </div>
                <div class="product-calc__price-group-currency">₽</div>
            </div>
        <?php endif; ?>
        <div class="product-calc__control-group">
            <input type="hidden" name="count" class="product-calc__count js-product-calc-price" value="<?= $resultPrice; ?>">
            <?php if ($showControl or $showPrice): ?>
                <div class="div">
                    <?php if ($showControl): ?>
                        <button class="product-calc__control product-calc__minus js-product-calc-minus" type="button">-</button>
                        <input name="count" type="text" class="product-calc__count js-product-calc-amount" value="<?= ($basket->count ? $basket->count : 1) ?>" placeholder="1">
                        <button class="product-calc__control product-calc__plus js-product-calc-plus" type="button">+</button>
                    <?php endif; ?>

                    <?php if ($showPrice): ?>
                        <div class="product-calc__price-info">
                            <?php if ($discount): ?>
                                <div class="product-calc__price-info-normal">Цена за товар: <?= Price::format($price); ?><?= Currency::getInstance()->show(); ?></div>
                                <?php /*<div class="product-calc__price-info-discount">Со скдикой: <?= Price::format($discount); ?><?= Currency::getInstance()->show(); ?></div>*/ ?>
                            <?php else: ?>
                                <div class="product-calc__price-info-normal">Цена за товар: <?= Price::format($price); ?><?= Currency::getInstance()->show(); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <input type="hidden" name="count" class="product-calc__count js-product-calc-amount" value="1">
            <?php endif; ?>



            <?php if ($showButton): ?>
                <?php if (BasketHelper::inBasket($product_id)): ?>
                    <button class="add-basket" type="button">
                        <img class="add-basket__icon" src="/upload/images/arrow-success.png">
                        <span class="add-basket__label">В корзине</span>
                    </button>
                <?php else: ?>
                    <button class="add-basket js-add-basket" type="submit" onclick="ym(55089223, 'reachGoal', 'basket'); return true;">
                        <img class="add-basket__icon" src="/upload/images/basket.png">
                        <span class="add-basket__label">В корзину</span>
                    </button>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($showOneClick): ?>
                <div class="buy-one-click-react" data-product-id="<?= $product_id; ?>"></div>
            <?php endif; ?>
        </div>
        <?php if ($showCompare): ?>
            <div class="compare-button-react" data-already="<?= CompareHelper::isComparing($product_id); ?>" data-id="<?= $product_id; ?>">Сравнить товар</div>
        <?php endif; ?>
    </form>
</div>
