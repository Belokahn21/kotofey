<?php

use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\widgets\Breadcrumbs;
use app\modules\media\models\entity\Media;
use app\modules\vendors\models\entity\Vendor;
use app\modules\seo\models\tools\ProductTitle;
use app\modules\reviews\models\entity\Reviews;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\models\helpers\HtmlProductHelper;
use app\modules\catalog\models\helpers\ProductCategoryHelper;
use app\modules\catalog\models\helpers\CompositionMetricsHelper;
use app\modules\catalog\widgets\PriceHistory\PriceHistoryWidget;
use app\modules\catalog\widgets\CatalogSliders\Analog\AnalogWidget;
use app\modules\reviews\widgets\ProductReviews\ProductReviewsWidget;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\widgets\VisitedProducts\VisitedProductsWidget;
use app\modules\catalog\widgets\CatalogSliders\Recomended\RecomendedWidget;
use app\modules\reviews\widgets\ProductReviewsForm\ProductReviewsFormWidget;
use app\modules\promotion\widgets\PromotionsForProduct\PromotionsForProductWidget;

/* @var $propertiesValues \app\modules\catalog\models\entity\PropertiesProductValues[]
 * @var \yii\web\View $this
 * @var \app\modules\catalog\models\entity\Product $product
 * @var \app\modules\catalog\models\entity\ProductCategory $category
 * @var $compositionGroup array
 */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if ($category) {
    $subsections = ProductCategoryHelper::getInstance()->getBreadcrumbs($category);
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

                <div class="swiper-container product-gallery-big" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff">
                    <div class="swiper-wrapper">
                        <a href="<?= ProductHelper::getImageUrl($product); ?>" class="swiper-slide product-gallery-big__slide" data-lightbox="roadtrip">
                            <img src="<?= ProductHelper::getImageUrl($product, false, array("width" => 300, "height" => 400, "crop" => "fit")); ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                        </a>

                        <?php if ($product->images): ?>
                            <?php foreach (Json::decode($product->images) as $image): ?>
                                <a href="<?= $image; ?>" data-lightbox="roadtrip" class="swiper-slide product-gallery-big__slide">
                                    <img src="<?= $image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($product, 23)): ?>
                            <?php foreach ($imagesFromProperty as $propertyValue): ?>
                                <?php if ($propertyValue->media): ?>
                                    <?php if ($propertyValue->media->location == Media::LOCATION_CDN): ?>
                                        <a href="<?= $propertyValue->media->cdnData['secure_url']; ?>" data-lightbox="roadtrip" class="swiper-slide product-gallery-big__slide">
                                            <img src="<?= $propertyValue->media->cdnData['secure_url']; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                                        </a>
                                    <?php else: ?>
                                        <a href="/upload/<?= $propertyValue->media->path; ?>" data-lightbox="roadtrip" class="swiper-slide product-gallery-big__slide">
                                            <img src="/upload/<?= $propertyValue->media->path; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="swiper-container product-gallery-thumbs" thumbsslider="">
                    <div class="swiper-wrapper">
                        <?php if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($product, 23) || $product->images): ?>

                            <div class="swiper-slide product-gallery-thumbs__slide"><img src="<?= ProductHelper::getImageUrl($product); ?>" title="<?= $product->name; ?>"></div>


                            <?php if ($product->images): ?>
                                <?php foreach (Json::decode($product->images) as $image): ?>
                                    <div class="swiper-slide product-gallery-thumbs__slide"><img src="<?= $image; ?>" title="<?= $product->name; ?>"></div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($product, 23)): ?>
                                <?php foreach ($imagesFromProperty as $propertyValue): ?>
                                    <?php if ($propertyValue->media): ?>
                                        <?php if ($propertyValue->media->location == Media::LOCATION_CDN): ?>
                                            <div class="swiper-slide product-gallery-thumbs__slide"><img src="<?= $propertyValue->media->cdnData['secure_url']; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"></div>
                                        <?php else: ?>
                                            <div class="swiper-slide product-gallery-thumbs__slide"><img src="/upload/<?= $propertyValue->media->path; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="product-blocks">
                <div class="product-blocks__item product-bonus">
                    <?php $bouns = BonusHelper::calcProductBonus($product); ?>
                    <div class="product-bonus__count">+<?= $bouns; ?></div>
                    <div class="product-bonus__title"><?= \Yii::t('app', '{n, plural, =0{бонусов} =1{бонус} one{бонус} few{бонусов} many{бонусов} other{бонуса}} на счёт', ['n' => $bouns]); ?></div>
                </div>
            </div>

            <?= PromotionsForProductWidget::widget([
                'product_id' => $product->id
            ]); ?>

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
            <h1 itemprop="name" content="<?= $product->name; ?>" class="product-detail__title"><?= $product->name; ?></h1>

            <?php if ($propertiesValues): ?>
                <?php foreach ($propertiesValues as $property): ?>
                    <?php if ($property->property && $property->property->id == 1): ?>
                        <div class="product-detail__brand">
                            <div>Бренд</div>
                            <a href="<?= ProductPropertiesValuesHelper::getBrandDetailUrl($property->variant); ?>">
                                <span itemprop="brand"><?= ProductPropertiesValuesHelper::getFinalValue($property); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?= HtmlProductHelper::showHtmlCountBuy($product); ?>
            <?= AddBasketWidget::widget([
                'product' => $product,
                'showOrderButton' => true,
                'showOneClick' => true,
            ]); ?>
            <?php /*= WhenCanBuyWidget::widget([
                'product' => $product
            ]); */ ?>
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


    <?= RecomendedWidget::widget([
        'property_id' => 19,
        'product' => $product
    ]); ?>

    <nav class="product-tabs in-product">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Описание</a>
            <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="false">Иструкция</a>
            <a class="nav-item nav-link" id="nav-buy-tab" data-toggle="tab" href="#nav-buy" role="tab" aria-controls="nav-buy" aria-selected="false">Состав товара</a>
            <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Отзывы (<?= Reviews::find()->where(['product_id' => $product->id, 'is_active' => 1, 'status_id' => Reviews::STATUS_ENABLE])->count(); ?>)</a>
        </div>
    </nav>
    <div class="tab-content product-tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" itemprop="description">
            <div class="news-detail-text pt-2"><?= $product->description ?: 'Отсутсвует'; ?></div>
        </div>
        <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
            <div class="news-detail-text pt-2"><?= $product->instruction ?: 'Отсутсвует'; ?></div>
        </div>
        <div class="tab-pane fade" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">

            <div class="list-composition-wrap">
                <?php foreach ($compositionGroup as $group_id => $data): ?>

                    <h4><?= $data['group']->name; ?></h4>

                    <ul class="list-composition">

                        <?php foreach ($data['items'] as $item): ?>
                            <li class="list-composition-item">
                                <div class="list-composition-item__key"><?= $item->composition->name; ?></div>
                                <div class="list-composition-item__value"><?= $item->value; ?><?= ArrayHelper::getValue(CompositionMetricsHelper::getMetrics(), $item->metric_id); ?></div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
            <?php if ($product->vendor_id == Vendor::VENDOR_ID_ROYAL): ?>
                <?= Html::img('/images/royal_reward.jpg', ['style' => 'width:100%; object-fit:contain;', 'class' => 'my-3']); ?>
            <?php endif; ?>
            <?= ProductReviewsWidget::widget([
                'product_id' => $product->id

            ]); ?>
            <?= ProductReviewsFormWidget::widget([
                'product_id' => $product->id
            ]); ?>
        </div>
    </div>
</div>

<?= AnalogWidget::widget([
    'property_id' => 21,
    'product' => $product
]); ?>
<?= VisitedProductsWidget::widget(); ?>
<?php /* SpecialPromoModalWidget::widget([
    'product' => $product
]); */ ?>

<?= PriceHistoryWidget::widget(['product' => $product]); ?>
