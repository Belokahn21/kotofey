<?php

use app\models\tool\Currency;
use app\models\entity\Basket;

/* @var $model \app\models\entity\Product */
?>
<div class="mini-catalog__item swiper-slide">
	<?php if (!empty($model->image) and is_file(Yii::getAlias('@webroot/upload/') . $model->image)): ?>
        <img class="mini-catalog__image catalog-list__image" src="/upload/<?= $model->image; ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>">
	<?php else: ?>
        <img class="mini-catalog__image catalog-list__image" src="/upload/images/not-image.png" alt="<?= $model->name; ?>" title="<?= $model->name; ?>">
	<?php endif; ?>

    <a href="<?= $model->detail; ?>" class="catalog-list__link">
        <div class="mini-catalog__title catalog-list__title"><?= $model->name; ?></div>
    </a>

    <div class="mini-catalog__group-price catalog-list__group-price">
        <div class="catalog-list__price">
            <div class="value"><?= $model->price; ?> <?= Currency::getInstance()->show(); ?></div>
            <!--            <div class="bonus">4 бонуса</div>-->
        </div>

        <div class="catalog-list__group-cart">
            <div onclick="ym(55089223, 'reachGoal', 'basket'); return true;" class="product-button product-add-basket<?= (!Basket::getInstance()->exist($model->id)) ? '' : ' hide'; ?>" data-product="<?= $model->id; ?>">
                В корзину
            </div>


            <div class="product-detail-calc-wrap<?= ((Basket::getInstance()->exist($model->id)) ? '' : ' hide'); ?>">
                <div class="product-detail-calc-form calc-form">

                    <div class="product-detail-calc-element calc-form__element">
                        <div class="calc-min calc-form__do-min" data-product="<?= $model->id; ?>">-</div>
                    </div>

                    <div class="product-detail-calc-element calc-form__element">
                        <input type="text" class="calc-count calc-form__count" name="count" placeholder="1" value="<?= Basket::findOne($model->id)->count; ?>">
                    </div>

                    <div class="product-detail-calc-element calc-form__element">
                        <div class="calc-plus calc-form__do-plus" data-product="<?= $model->id; ?>">+</div>
                    </div>
                </div>
            </div>

            <ul class="summary">
                <li class="summary__item available">В наличии</li>
                <li class="summary__item">Арткиул: <?= $model->article; ?></li>
            </ul>

        </div>
    </div>
</div>