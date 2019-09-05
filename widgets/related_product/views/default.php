<?

use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\models\tool\Currency;
use app\models\entity\Favorite;
$currency = new Currency();
?>
<div class="catalog">
    <h2 class="related-products__title">Похожие товары</h2>
    <? foreach ($products as $product): ?>
        <div class="item">
            <div class="item-bookmark" data-id="<?= $product->id; ?>">
                <i class="<?= (Favorite::isProductInFavorite($product->id)) ? "fas" : "far"; ?> fa-bookmark"></i>
            </div>
            <div class="catalog-element__image">
                <a href="<?=$product->image;?>" class="image-link">
                    <img src="<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"/>
                </a>
            </div>
            <div class="catalog-element__title">
                <h3><a href="<?= $product->detail; ?>"><?= $product->display; ?></a></h3>
            </div>
            <div class="catalog-element__content">
                <span class="catalog-element__content-price">
                    <span class="left-col">
                        <?= Price::format($product->price); ?> <?= $currency->show(); ?>
                    </span>
                    <span class="right-col">
                        <? if ($product->count > 0): ?>
                            <a href="" class="add-basket btn-basket" data-id="<?= $product->id; ?>">В корзину</a>
                        <? else: ?>
                            <a href="" class="catalog-element__empty" >Нет в наличии</a>
                        <? endif; ?>
                    </span>
                </span>
            </div>
            <div class="clearfix"></div>
        </div>
    <? endforeach; ?>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
