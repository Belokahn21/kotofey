<?php
/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\favorite\models\entity\Favorite;

$this->title = Title::showTitle("Избранные товары");
$this->params['breadcrumbs'][] = ['label' => 'Избранные товары', 'url' => ['/favorite/']]; ?>
<h1 class="favorite__title">Избранные товары</h1>
<? if (!empty($products)): ?>
    <div class="catalog">
		<?php foreach ($products as $product): ?>
            <div class="item">
                <div class="item-bookmark" data-id="<?= $product->id; ?>">
                    <i class="<?= (Favorite::isProductInFavorite($product->id)) ? "fas" : "far"; ?> fa-bookmark"></i>
                </div>
                <div class="catalog-element__image">
                    <img src="<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                    <div class="catalog-element__links">
                        <a href="" class="btn-effect bubble left catalog-element__links-element add-basket"
                           data-id="<?= $product->id; ?>">Вкорзину</a>
                        <a href="<?= $product->detail; ?>" class="catalog-element__links-element">Просмотр</a>
                    </div>
                </div>
                <div class="catalog-element__title">
                    <h3><a href="<?= $product->detail; ?>"><?= $product->display; ?></a></h3>
                </div>
                <div class="catalog-element__content">
                    <div class="catalog-element__content-price">
						<?= Price::format($product->price); ?> <?= (new Currency())->show(); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
		<?php endforeach; ?>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
<? else: ?>
    <h1 style="color: white;">Увы, но вы ничего не добавили в закладки.</h1><a href="/catalog/">Перейти в катаолг</a>
<? endif; ?>
