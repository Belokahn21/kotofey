<?php
/* @var $this yii\web\View */
/* @var $products \app\modules\catalog\models\entity\Product */

/* @var $currency Currency */

use app\modules\basket\models\helpers\BasketHelper;
use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\models\tool\Currency;
use yii\helpers\Html;
use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Product;

$this->title = Title::showTitle("Корзина товаров");
$this->params['breadcrumbs'][] = ['label' => 'Корзина товаров', 'url' => ['/basket/']];
?>
<section class="basket">
    <h1>Корзина товаров</h1>
	<?php if (Basket::count() > 0): ?>
		<?= Html::a('Очистить корзину', "/clear/", ['class' => 'btn-cancel']); ?>
		<?= Html::a('Оформить заказ', "/order/", ['class' => 'btn-main']); ?>
	<?php endif; ?>
	<?php if (!empty(Yii::$app->session->get('basket'))): ?>
        <ul class="basket-page-list">
			<?php /* @var $item \app\modules\order\models\entity\OrdersItems */ ?>
			<?php foreach (Basket::findAll() as $item): ?>
                <li class="basket-page-item">
                    <div class="basket-page-item__image-wrap">

						<?php if ($item->product instanceof Product): ?>
                            <a href="<?= $item->product->detail; ?>">
								<?php if (!empty($item->product->image) and is_file(Yii::getAlias('@webroot/upload/') . $item->product->image)): ?>
                                    <img src="/upload/<?= $item->product->image; ?>">
								<?php else: ?>
                                    <img src="/upload/images/not-image.png">
								<?php endif; ?>
                            </a>
						<?php else: ?>
                            <a href="javascript:void(0);">
								<?php if (!empty($item->product->image) and is_file(Yii::getAlias('@webroot/upload/') . $item->product->image)): ?>
                                    <img src="/upload/<?= $item->product->image; ?>">
								<?php else: ?>
                                    <img src="/upload/images/not-image.png">
								<?php endif; ?>
                            </a>
						<?php endif; ?>

                    </div>
                    <div class="basket-page-item__title">

						<?php if ($item->product instanceof Product): ?>
                            <a href="<?= $item->product->detail; ?>"><?= $item->product->name; ?></a>
						<?php else: ?>
                            <a href="javascript:void(0);"><?= $item->name; ?></a>
						<?php endif; ?>

                    </div>
                    <div class="basket-page-item__calculate">
                        <div class="basket-page-item__price">
							<?= Price::format($item->price); ?> <?= Currency::getInstance()->show(); ?>
                        </div>
                        <div class="basket-page-item__form product-detail-calc-form">
                            <span class="calc-min" data-product="<?= $item->product->id; ?>"><i class="fas fa-minus"></i></span>
                            <input class="basket-page-item__form-input calc-count" type="text" name="count" placeholder="1" value="<?= $item->count; ?>">
                            <span class="calc-plus" data-product="<?= $item->product->id; ?>"><i class="fas fa-plus"></i></span>
                        </div>
                    </div>
                </li>
			<?php endforeach; ?>
        </ul>
	<?php else: ?>
        Ничего не выбрано
	<?php endif; ?>
</section>
