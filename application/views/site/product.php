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
use app\models\entity\ProductOrder;
use app\modules\catalog\models\entity\Product;
use app\models\services\BonusByBuyService;

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

if (BonusByBuyService::isActive()):
	echo $this->render('modal/product-modal-bonus');
endif;
echo $this->render('modal/product-modal-delivery');
echo $this->render('modal/product-modal-payment');
?>
<div class="product-detail-wrap">
    <div class="container">
        <div class="row">
            <div class="col col-sm-4">
                <div class="product-detail-image-wrap">
					<?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                        <a href="/upload/<?= $product->image; ?>" data-lightbox="roadtrip" class="product-detail-image--link">
                            <img class="product-detail-image" src="/upload/<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                        </a>
					<?php else: ?>
                        <img class="product-detail-image" src="/upload/images/not-image.png" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
					<?php endif; ?>

					<?php if (!empty($product->images)): ?>
						<?php foreach (Json::decode($product->images) as $image_path): ?>
                            <a href="<?= $image_path; ?>" data-lightbox="roadtrip" class="product-detail-image--link">
                                <img class="product-detail-image" src="<?= $image_path; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                            </a>
						<?php endforeach; ?>
					<?php endif; ?>

                </div>

                <div class="social-share-title">Поделиться</div>
				<?= \ymaker\social\share\widgets\SocialShare::widget([
					'configurator' => 'socialShare',
					'url' => \yii\helpers\Url::to('https://kotofey.store' . $product->detail, true),
					'title' => $product->name,
					'description' => $product->description,
					'imageUrl' => \yii\helpers\Url::to('https://kotofey.store/upload/' . $product->image, true),
				]); ?>
            </div>
            <div class="w-100 hide"></div>
            <div class="col col-sm-6">
                <div class="product-title"><?= $product->name; ?></div>
                <div class="product-control">
					<?php if ($product->active == 1): ?>
						<?php if ($date = ProductOrder::productIsOrder($product->id)): ?>
                            <div class="product-available red">Под заказ от <?= $date->start; ?> до <?= $date->end; ?> дней</div>
						<?php else: ?>
							<?php if ($product->vitrine == 1 or $product->count > 0): ?>
                                <div class="product-available green">В наличии <span><?= ($product->count > 0 ? $product->count . 'шт.' : null); ?></span></div>
							<?php endif; ?>
						<?php endif; ?>
					<?php else: ?>
                        <div class="product-available red">Нет в наличии</div>
					<?php endif; ?>

                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="product-favorite add-to-favorite" onclick="ym(55089223, 'reachGoal', 'favorite'); return true;" data-product="<?= $product->id; ?>"><i class="<?= ((Favorite::getInstance()->exist($product->id)) ? 'fas' : 'far'); ?> fa-heart"></i>В избранное</div>
                    <div class="product-favorite add-to-compare" onclick="ym(55089223, 'reachGoal', 'compare'); return true;" data-product="<?= $product->id; ?>">
                        <i class="fas fa-balance-scale"></i>Сравнить
                    </div>

                    <!--                            <div class="product-share" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"><i class="fas fa-share-alt"></i>Поделиться</div>-->
                </div>
                <div class="product-description">
					<?php if ($product->description): ?>
						<?= $product->description; ?>
					<?php endif; ?>
                </div>
            </div>
            <div class="col-2">
                <div class="product-detail-sidebar">
                    <div class="product-price-wrap">
                        <span class="product-price"><?= Price::format(ProductHelper::getResultPrice($product)); ?> <?= Currency::getInstance()->show(); ?></span> за шт
                    </div>


					<?php if (BonusByBuyService::isActive()): ?>
                        <div class="product-discount-wrap">
                            получаете <span class="product-discount__value"><?= DiscountHelper::calcBonus($product->price); ?></span> бонусов
                        </div>
					<?php endif; ?>

                    <div onclick="ym(55089223, 'reachGoal', 'basket'); return true;" class="product-button product-add-basket <?= (!Basket::getInstance()->exist($product->id)) ? '' : 'hide'; ?>" data-product="<?= $product->id; ?>">
                        В корзину
                    </div>


                    <div class="product-detail-calc-wrap <?= ((Basket::getInstance()->exist($product->id)) ? '' : 'hide'); ?>">
                        <div class="product-detail-calc-form calc-form">

                            <div class="product-detail-calc-element calc-form__element">
                                <div class="calc-min calc-form__do-min" data-product="<?= $product->id; ?>">-</div>
                            </div>

                            <div class="product-detail-calc-element">
                                <input type="text" class="calc-count calc-form__count" name="count" placeholder="1" value="<?= Basket::findOne($product->id)->count; ?>">
                            </div>

                            <div class="calc-element calc-form__element">
                                <div class="calc-plus calc-form__do-plus" data-product="<?= $product->id; ?>">+</div>
                            </div>
                        </div>
                    </div>
					<?php /* FastBuyWidget::widget([
						'product' => $product
					]); */ ?>

                    <hr/>
					<?php /* WeightBuyWidget::widget([
						'product_id' => $product->id
					]); */ ?>

                    <ul class="product-pluses">
                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-delivery">
                            <div class="product-pluses__icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="product-pluses__title">Бесплатная доставка</div>
                        </li>

						<?php if (BonusByBuyService::isActive()): ?>
                            <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-sale">
                                <div class="product-pluses__icon">
                                    <i class="fas fa-piggy-bank"></i>
                                </div>
                                <div class="product-pluses__title">Скидки на покупки</div>
                            </li>
						<?php endif; ?>

                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-payment">
                            <div class="product-pluses__icon"><i class="far fa-credit-card"></i>
                            </div>
                            <div class="product-pluses__title">Оплата при получении</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="product-attributes-wrap">
        <div class="container">
            <div class="product-attributes__title">Характеристики товара</div>
			<?php if (!empty($product->article)): ?>
                <div class="row product-attributes__item">
                    <div class="col-4 product-attributes__key"><?= (new Product())->getAttributeLabel('article'); ?></div>
                    <div class="col product-attributes__value"><?= $product->article; ?></div>
                </div>
			<?php endif; ?>
			<?php if ($properties): ?>
				<?php foreach ($properties as $property): ?>
                    <div class="row product-attributes__item">
                        <div class="col-4 product-attributes__key"><?= $property->property->name; ?></div>
                        <div class="col product-attributes__value"><?= $property->finalValue; ?></div>
                    </div>
				<?php endforeach; ?>
			<?php endif; ?>

        </div>
        <div class="container">
			<?= ProductReviewsWidget::widget([
				'product' => $product
			]); ?>
        </div>
    </div>

    <div class="lkj d-sm-none">
        <div class="row">
            <div class="col-4">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-4">Цена</div>
                    <div class="col-8"><?= $product->price; ?> <?= Currency::getInstance()->show(); ?></div>
                </div>
            </div>
            <div class="col-8">
                <div class="product-button product-add-basket <?= (!Basket::getInstance()->exist($product->id)) ? '' : 'hide'; ?>" data-product="<?= $product->id; ?>">
                    В корзину
                </div>


                <div class="product-detail-calc-wrap <?= ((Basket::getInstance()->exist($product->id)) ? '' : 'hide'); ?>">
                    <div class="product-detail-calc-form calc-form">

                        <div class="product-detail-calc-element calc-form__element">
                            <div class="calc-min calc-form__do-min" data-product="<?= $product->id; ?>">-</div>
                        </div>

                        <div class="product-detail-calc-element">
                            <input type="text" class="calc-count calc-form__count" name="count" placeholder="1" value="<?= Basket::findOne($product->id)->count; ?>">
                        </div>

                        <div class="calc-element calc-form__element">
                            <div class="calc-plus calc-form__do-plus" data-product="<?= $product->id; ?>">+</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
