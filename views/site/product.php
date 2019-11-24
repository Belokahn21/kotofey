<?

use app\widgets\product_reviews\ProductReviewsWidget;
use app\models\entity\Basket;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\entity\ProductPropertiesValues;
use app\widgets\fast_buy\FastBuyWidget;
use app\models\entity\Favorite;
use yii\helpers\Json;
use app\models\entity\ProductOrder;

/* @var $properties ProductPropertiesValues[] */
/* @var \yii\web\View $this */
/* @var \app\models\entity\Product $product */
/* @var \app\models\entity\Category $category */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if ($category) {
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/catalog/' . $category->slug . "/"]];
}
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => [$product->detail]];

$this->title = Title::showTitle($product->name);

echo $this->render('modal/product-modal-bonus');
echo $this->render('modal/product-modal-delivery');
echo $this->render('modal/product-modal-payment');
?>
<div class="product-detail-wrap">
    <div class="container">
        <div class="row">
            <div class="col col-sm-4">
                <div class="product-detail-image-wrap">
                    <?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                        <img class="product-detail-image" src="/web/upload/<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                    <?php else: ?>
                        <img class="product-detail-image" src="/web/upload/images/not-image.png" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                    <?php endif; ?>

                    <?php if (!empty($product->images)): ?>
                        <?php foreach (Json::decode($product->images) as $image_path): ?>
                            <img class="product-detail-image" src="<?= $image_path; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
            <div class="w-100 hide"></div>
            <div class="col col-sm-6">
                <div class="product-title"><?= $product->name; ?></div>
                <div class="product-control">
                    <?php if ($date = ProductOrder::productIsOrder($product->id)): ?>
                        <div class="product-available red">Под заказ от <?= $date->start; ?> до <?= $date->end; ?> дней</div>
                    <?php else: ?>
                        <?php if ($product->vitrine == 1 or $product->count > 0): ?>
                            <div class="product-available green">В наличии</div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="product-favorite add-to-favorite" data-product="<?= $product->id; ?>"><i class="<?= ((Favorite::getInstance()->exist($product->id)) ? 'fas' : 'far'); ?> fa-heart"></i>В избранное</div>
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
                        <span class="product-price"><?= Price::format($product->price); ?> <?= Currency::getInstance()->show(); ?></span> за шт
                    </div>
                    <div class="product-button product-add-basket <?= (!Basket::getInstance()->exist($product->id)) ? '' : 'hide'; ?>" data-product="<?= $product->id; ?>">
                        В корзину
                    </div>


                    <div class="product-detail-calc-wrap <?= ((Basket::getInstance()->exist($product->id)) ? '' : 'hide'); ?>">
                        <form class="product-detail-calc-form">

                            <div class="product-detail-calc-element">
                                <div class="product-detail-calc-min" data-product="<?= $product->id; ?>">-</div>
                            </div>

                            <div class="product-detail-calc-element">
                                <input type="text" class="product-detail-calc-count" name="count" placeholder="1" value="<?= Basket::findOne($product->id)->getCount(); ?>">
                            </div>

                            <div class="product-detail-calc-element">
                                <div class="product-detail-calc-plus" data-product="<?= $product->id; ?>">+</div>
                            </div>
                        </form>
                    </div>
                    <?= FastBuyWidget::widget([
                        'product' => $product
                    ]); ?>
                    <hr/>
                    <ul class="product-pluses">
                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-delivery">
                            <div class="product-pluses__icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="product-pluses__title">Бесплатная доставка</div>
                        </li>

                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-sale">
                            <div class="product-pluses__icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="product-pluses__title">Скидки на покупки</div>
                        </li>

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
</div>
