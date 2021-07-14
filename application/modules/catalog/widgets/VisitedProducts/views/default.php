<?php

use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\Price;
use yii\helpers\Url;

/* @var $products \app\modules\catalog\models\entity\Offers[] */
?>

<?php if (!$products) return false; ?>

<h2>Ранее просмотренные товары</h2>

<div class="catalog-line recommended-products">
    <?php foreach ($products as $product): ?>
        <div class="catalog-line__item">
            <div class="catalog-line__image"><img src="<?= OfferHelper::getImageUrl($product); ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"></div>
            <div class="catalog-line__name">
                <a href="<?= OfferHelper::getDetailUrl($product); ?>"><?= $product->name; ?></a>
            </div>
            <div class="catalog-line__price"><?= Price::format($product->getPrice()); ?><?= Currency::getInstance()->show(); ?></div>
            <div class="catalog-line__to-cart">
                <?= AddBasketWidget::widget([
                    'product' => $product,
                    'showInfo' => false,
                    'showOneClick' => false,
                    'showControl' => true,
                    'showButton' => true,
                ]) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
