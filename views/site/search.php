<?php

use app\models\entity\Basket;
use app\models\entity\ProductPropertiesValues;
use app\models\helpers\DiscountHelper;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\entity\SiteSettings;

/* @var $products \app\models\entity\Product[] */

$this->title = Title::showTitle("Поиск по сайту");
$this->params['breadcrumbs'][] = ['label' => 'Поиск по сайту', 'url' => ['/search/']]; ?>
<?php if ($products): ?>
    <ul class="catalog-list w-100">
		<?php foreach ($products as $product): ?>
            <li class="catalog-list__item">

				<?php $weight = ProductPropertiesValues::findOne(['product_id' => $product->id, 'property_id' => '2']); ?>
				<?php if ($weight): ?>
                    <div class="catalog-list__weight"><?= $weight->value; ?> КГ</div>
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
                                    <input type="text" class="product-detail-calc-count" name="count" placeholder="1" value="<?= Basket::findOne($product->id)->count; ?>">
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
<?php else: ?>
    <p style="text-align: center; margin: 20px 0;">
        К сожаление ничего не нашлось :(
    </p>
    <p style="text-align: center;margin: 20px 0;">
        Попробуйте изменить тактику поиска, поменяв язык. К примеру искали <strong>"Проплан"</strong> попробуйте <strong>"Pro plan"</strong>
    </p>
    <p style="text-align: center;margin: 20px 0;">
        Позвоните нам по номеру <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="phone_mask" style="color: #ff1a4a; font-weight: bold;"><?= SiteSettings::getValueByCode('phone_1'); ?></a> и мы быстро найдем ваш товар
    </p>
    <p style="text-align: center;margin: 20px 0;">
        Или воспользуйтесь чатом в правом нижнем углу, мы отвечаем <span style="color: #ff1a4a; font-weight: bold; text-transform: uppercase;">моментально</span>
    </p>
    <img src="/upload/images/chat.png"/ style="width: auto; margin: auto auto;">
<?php endif; ?>