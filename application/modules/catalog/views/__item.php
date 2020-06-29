<?php

use app\modules\basket\models\entity\Basket;
use app\models\tool\Currency;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\models\helpers\DiscountHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\models\tool\Price;
use app\models\services\BonusByBuyService;

/* @var $product \app\modules\catalog\models\entity\Product */
?>

<li class="catalog-list__item">
    <?php if ($product->discount_price): ?>
        <div id="burst-12">
            <div class='dis'>
                <?= floor((($product->discount_price - $product->price) / $product->price) * 100); ?>%
            </div>
        </div>
    <?php endif; ?>

    <?php if ($weight = ProductPropertiesValues::findOne(['product_id' => $product->id, 'property_id' => '2'])): ?>
        <div class="catalog-list__weight">
            <?= $weight->value; ?> КГ
        </div>
    <?php endif; ?>

    <a href="<?= $product->detail; ?>" class="catalog-list__link">
        <?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
            <img class="catalog-list__image" src="/upload/<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
        <?php else: ?>
            <img class="catalog-list__image" src="/upload/images/not-image.png" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
        <?php endif; ?>
    </a>

    <a href="<?= $product->detail; ?>" class="catalog-list__link">
        <div class="catalog-list__title"><?= $product->name; ?></div>
    </a>
    <div class="catalog-list__group-price">
        <div class="catalog-list__price">
            <div class="value"><?= Price::format(ProductHelper::getResultPrice($product)); ?> <?= Currency::getInstance()->show(); ?></div>
            <?php if (BonusByBuyService::isActive()): ?>
                <div class="bonus"><?= DiscountHelper::calcBonus($product->price); ?> бонуса</div>
            <?php endif; ?>
        </div>

        <div class="catalog-list__group-cart">
            <div onclick="ym(55089223, 'reachGoal', 'basket', {
            	name: '<?=$product->name;?>'
            }); return true;" class="product-button product-add-basket<?= (!Basket::getInstance()->exist($product->id)) ? '' : ' hide'; ?>" data-product="<?= $product->id; ?>">
                В корзину
            </div>


            <div class="product-detail-calc-wrap<?= ((Basket::getInstance()->exist($product->id)) ? '' : ' hide'); ?>">
                <div class="product-detail-calc-form calc-form">

                    <div class="product-detail-calc-element calc-form__element">
                        <div class="calc-min calc-form__do-min" data-product="<?= $product->id; ?>">-</div>
                    </div>

                    <div class="product-detail-calc-element calc-form__element">
                        <input type="text" class="calc-count calc-form__count" name="count" placeholder="1" value="<?= Basket::findOne($product->id)->count; ?>">
                    </div>

                    <div class="product-detail-calc-element calc-form__element">
                        <div class="calc-plus calc-form__do-plus" data-product="<?= $product->id; ?>">+</div>
                    </div>
                </div>
            </div>

            <ul class="summary">
                <li class="summary__item available">В наличии</li>
                <li class="summary__item">Арткиул: <?= $product->article; ?></li>
            </ul>

        </div>
    </div>
</li>