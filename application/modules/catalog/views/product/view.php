<?php

use yii\helpers\Json;
use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\ProductTitle;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\widgets\WhenCanBuy\WhenCanBuyWidget;
use app\modules\catalog\widgets\CatalogSliders\Analog\AnalogWidget;
use app\modules\reviews\widgets\ProductReviews\ProductReviewsWidget;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\widgets\VisitedProducts\VisitedProductsWidget;
use app\modules\catalog\widgets\CatalogSliders\Recomended\RecomendedWidget;

/* @var $propertiesValues \app\modules\catalog\models\entity\PropertiesProductValues[]
 * @var \yii\web\View $this
 * @var \app\modules\catalog\models\entity\Product $product
 * @var \app\modules\catalog\models\entity\ProductCategory $category
 */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if ($category) {
    $subsections = $category->undersections();
    for ($i = 0; $i < count($subsections); $i++) {
        $parents = $subsections[$i];
        $this->params['breadcrumbs'][] = ['label' => $parents->name, 'url' => ['/catalog/' . $parents->slug . "/"]];
    }
}
$this->params['breadcrumbs'][] = ['label' => $product->name];

$this->title = ProductTitle::show($product->name);

?>
    <div itemscope itemtype="http://schema.org/Product">
        <div class="product-detail" itemscope itemtype="http://schema.org/Product">
            <div class="product-detail-left">
                <div class="product-detail-gallery">
                    <a itemprop="image" class="product-detail-gallery__link" href="<?= ProductHelper::getImageUrl($product); ?>" data-lightbox="roadtrip">
                        <img class="product-detail-gallery__image" src="<?= ProductHelper::getImageUrl($product, false, array("width" => 300, "height" => 400, "crop" => "fit")); ?>" title="<?= $product->name; ?>" alt="<?= $product->name; ?>">
                    </a>
                    <div class="product-detail-gallery__group">
                        <?php if ($product->images): ?>
                            <?php foreach (Json::decode($product->images) as $image): ?>
                                <a class="product-detail-gallery__link active" href="<?= $image; ?>" data-lightbox="roadtrip">
                                    <img class="product-detail-gallery__image" src="<?= $image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="product-blocks">
                    <div class="product-blocks__item product-bonus">
                        <?php $bouns = BonusHelper::calcProductBonus($product); ?>
                        <div class="product-bonus__count">+<?= $bouns; ?></div>
                        <div class="product-bonus__title"><?= \Yii::t('app', '{n, plural, =0{бонусов} =1{бонус} one{бонус} few{бонусов} many{бонусов} other{бонуса}} на счёт', ['n' => $bouns]); ?></div>
                    </div>
                </div>

            </div>
            <div class="product-detail-right">
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Главная ',
                        'url' => Yii::$app->homeUrl,
                        'title' => 'Первая страница сайта зоомагазина Котофей',
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]); ?>
                <h1 itemprop="name" class="product-detail__title"><?= $product->name; ?></h1>

                <?php if ($propertiesValues): ?>
                    <?php foreach ($propertiesValues as $property): ?>
                        <?php if ($property->property && $property->property->id == 1): ?>
                            <div class="product-detail__brand">
                                <div>Бренд</div>
                                <a href="<?= ProductPropertiesValuesHelper::getBrandDetailUrl($property->variant); ?>"><?= ProductPropertiesValuesHelper::getFinalValue($property); ?></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?= AddBasketWidget::widget([
                    'product' => $product,
                    'showOrderButton' => true,
                    'showOneClick' => false,
                    'price' => ProductHelper::getResultPrice($product),
                ]); ?>
                <?= WhenCanBuyWidget::widget([
                    'product' => $product
                ]); ?>
                <ul class="product-properties">
                    <li class="product-properties__line">
                        <div class="product-properties__key">Артикул</div>
                        <div class="product-properties__value"><?= $product->article; ?></div>
                    </li>
                    <?php if ($propertiesValues): ?>
                        <?php foreach ($propertiesValues as $property): ?>
                            <?php if (!$property->property) continue; ?>
                            <li class="product-properties__line">
                                <div class="product-properties__key"><?= $property->property->name; ?></div>
                                <div class="product-properties__value"><?= ProductPropertiesValuesHelper::getFinalValue($property); ?></div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <nav class="product-tabs in-product">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Описание</a>
                <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="false">Оплата</a>
                <a class="nav-item nav-link" id="nav-buy-tab" data-toggle="tab" href="#nav-buy" role="tab" aria-controls="nav-buy" aria-selected="false">Как купить?</a>
                <?php if (Yii::$app->user->id == 1): ?>
                    <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Отзывы</a>
                <?php endif; ?>
            </div>
        </nav>
        <div class="tab-content product-tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" itemprop="description">
                <?= $product->description ?: 'Отсутсвует'; ?>
            </div>
            <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                <strong>Оплатить можно:</strong>
                <ul>
                    <li>Наличными;</li>
                    <li>Через терминала.</li>
                </ul>
                <i>*Оплата только при получении заказа</i>
            </div>
            <div class="tab-pane fade" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">
                Для покупки товаров на нашем сайте вам нужно добавить интересующий вас товар в корзину и пройти к оформлению заказа.<br>
                После того как заказ был оформлен с вами свяжется оператор (через 15 минут) для уточнения деталей заказа и согласования времени доставки.
            </div>

            <?php if (Yii::$app->user->id == 1): ?>
                <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                    <?= ProductReviewsWidget::widget(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?= RecomendedWidget::widget([
    'property_id' => 19,
    'product' => $product
]); ?>

<?= AnalogWidget::widget([
    'property_id' => 21,
    'product' => $product
]); ?>
<?= VisitedProductsWidget::widget(); ?>