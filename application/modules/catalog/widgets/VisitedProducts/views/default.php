<?php

use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;
use yii\helpers\Url;

/* @var $products \app\modules\catalog\models\entity\Product[] */
?>

<?php if (!$products) return false; ?>

<div class="recommended-products-container">
    <h4 class="recommended-products-title">Вы смотрели</h4>
    <div class="catalog-line recommended-products">
        <?php foreach ($products as $product): ?>
            <div class="catalog-line__item">
                <div class="catalog-line__image"><img src="<?= ProductHelper::getImageUrl($product); ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"></div>
                <div class="catalog-line__name">
                    <a href="<?= ProductHelper::getDetailUrl($product); ?>"><?= $product->name; ?></a>
                </div>
                <div class="catalog-line__price"><?= PriceTool::format($product->getPrice()); ?><?= Currency::getInstance()->show(); ?></div>
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
</div>
