<?php

use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\models\helpers\ProductHelper;
use app\models\tool\Currency;
use app\models\tool\Price;
use yii\helpers\Url;

/* @var $products \app\modules\catalog\models\entity\Product[] */
?>

<?php if (!$products) return false; ?>

<h2>Ранее просмотренные товары</h2>

<div class="catalog-line">
    <?php foreach ($products as $product): ?>
        <div class="catalog-line__item">
            <div class="catalog-line__image"><img src="<?= ProductHelper::getImageUrl($product); ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"></div>
            <div class="catalog-line__name">
                <a href="<?= ProductHelper::getDetailUrl($product); ?>"><?= $product->name; ?></a>
            </div>
            <div class="catalog-line__price"><?= Price::format($product->getPrice()); ?><?= Currency::getInstance()->show(); ?></div>
            <div class="catalog-line__to-cart">
                <?= AddBasketWidget::widget([
                    'product' => $product,
                    'price' => $product->getPrice(),
                    'showInfo' => false,
                    'showOneClick' => false,
                    'showControl' => true,
                    'showButton' => true,
                ]) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
