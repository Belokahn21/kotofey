<?php

use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\ProductTitle;
use app\modules\reviews\models\entity\Reviews;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\widgets\WhenCanBuy\WhenCanBuyWidget;
use app\modules\catalog\widgets\CatalogSliders\Analog\AnalogWidget;
use app\modules\reviews\widgets\ProductReviews\ProductReviewsWidget;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\widgets\VisitedProducts\VisitedProductsWidget;
use app\modules\catalog\widgets\CatalogSliders\Recomended\RecomendedWidget;
use app\modules\reviews\widgets\ProductReviewsForm\ProductReviewsFormWidget;
use app\modules\promotion\widgets\PromotionsForProduct\PromotionsForProductWidget;
use app\modules\catalog\models\helpers\CompositionMetricsHelper;

/* @var $propertiesValues \app\modules\catalog\models\entity\PropertiesProductValues[]
 * @var \yii\web\View $this
 * @var \app\modules\catalog\models\entity\Offers $offer
 * @var \app\modules\catalog\models\entity\ProductCategory $category
 * @var $compositionGroup array
 */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if ($category) {
    $subsections = $category->undersections();
    for ($i = 0; $i < count($subsections); $i++) {
        $parents = $subsections[$i];
        $this->params['breadcrumbs'][] = ['label' => $parents->name, 'url' => ['/catalog/' . $parents->slug . "/"]];
    }
}
$this->params['breadcrumbs'][] = ['label' => $offer->name];

$this->title = ProductTitle::show($offer->name);

$other_offers = \app\modules\catalog\models\entity\Offers::find()->where(['product_id' => $offer->product_id])->andWhere(['<>', 'id', $offer->id])->all();
$formated_props = [];
foreach ($other_offers as $offer_item) {
    foreach ($offer_item->propsValues as $propsValue) {
        $formated_props[$propsValue->value][] = $propsValue;
    }
}

$build_data = [];
foreach ($formated_props as $key => $value) {

    foreach ($value as $item) {
        if (count($other_offers) == count($value)) continue;
        \app\modules\site\models\tools\Debug::p($key . '=' . count($value) . ' = ' . $item->property->name);

        $build_data[$item->property->id][] = $item->value;
    }
}

\app\modules\site\models\tools\Debug::p($build_data);
?>
    <div itemscope itemtype="http://schema.org/Product">
        <div class="product-detail" itemscope itemtype="http://schema.org/Product">
            <div class="product-detail-left">
                <div class="product-detail-gallery">

                    <div class="swiper-container product-gallery-big" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff">
                        <div class="swiper-wrapper">
                            <a href="<?= OfferHelper::getImageUrl($offer); ?>" class="swiper-slide product-gallery-big__slide" data-lightbox="roadtrip">
                                <img src="<?= OfferHelper::getImageUrl($offer, false, array("width" => 300, "height" => 400, "crop" => "fit")); ?>" alt="<?= $offer->name; ?>" title="<?= $offer->name; ?>">
                            </a>

                            <?php if ($offer->images): ?>
                                <?php foreach (Json::decode($offer->images) as $image): ?>
                                    <a href="<?= $image; ?>" data-lightbox="roadtrip" class="swiper-slide product-gallery-big__slide">
                                        <img src="<?= $image; ?>" alt="<?= $offer->name; ?>" title="<?= $offer->name; ?>">
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($offer, 23)): ?>
                                <?php foreach ($imagesFromProperty as $propertyValue): ?>
                                    <?php if ($propertyValue->media): ?>
                                        <a href="<?= $propertyValue->media->cdnData['secure_url']; ?>" data-lightbox="roadtrip" class="swiper-slide product-gallery-big__slide">
                                            <img src="<?= $propertyValue->media->cdnData['secure_url']; ?>" alt="<?= $offer->name; ?>" title="<?= $offer->name; ?>">
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <?php if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($offer, 23) || $offer->images): ?>
                        <div class="swiper-container product-gallery-thumbs" thumbsslider="">
                            <div class="swiper-wrapper">

                                <div class="swiper-slide product-gallery-thumbs__slide"><img src="<?= OfferHelper::getImageUrl($offer); ?>" title="<?= $offer->name; ?>"></div>


                                <?php if ($offer->images): ?>
                                    <?php foreach (Json::decode($offer->images) as $image): ?>
                                        <div class="swiper-slide product-gallery-thumbs__slide"><img src="<?= $image; ?>" title="<?= $offer->name; ?>"></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($offer, 22)): ?>
                                    <?php foreach ($imagesFromProperty as $propertyValue): ?>
                                        <?php if ($propertyValue->media): ?>
                                            <div class="swiper-slide product-gallery-thumbs__slide"><img src="<?= $propertyValue->media->cdnData['secure_url']; ?>" alt="<?= $offer->name; ?>" title="<?= $offer->name; ?>"></div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="product-blocks">
                    <div class="product-blocks__item product-bonus">
                        <?php $bouns = BonusHelper::calcProductBonus($offer); ?>
                        <div class="product-bonus__count">+<?= $bouns; ?></div>
                        <div class="product-bonus__title"><?= \Yii::t('app', '{n, plural, =0{бонусов} =1{бонус} one{бонус} few{бонусов} many{бонусов} other{бонуса}} на счёт', ['n' => $bouns]); ?></div>
                    </div>
                </div>

                <?= PromotionsForProductWidget::widget([
                    'product_id' => $offer->id
                ]); ?>


                <p>Вкус</p>
                <label>
                    Раки
                    <input type="radio" name="prop[1]" value="1">
                </label>
                <label>
                    Ягненок
                    <input type="radio" name="prop[1]" value="2">
                </label>


                <p>Вес</p>
                <label>
                    1кг
                    <input type="radio" name="prop[2]" value="1">
                </label>
                <label>
                    2кг
                    <input type="radio" name="prop[2]" value="2">
                </label>

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
                <h1 itemprop="name" class="product-detail__title"><?= $offer->name; ?></h1>

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
                    'product' => $offer,
                    'showOrderButton' => true,
                    'showOneClick' => true,
                ]); ?>
                <?= WhenCanBuyWidget::widget([
                    'product' => $offer
                ]); ?>
                <ul class="product-properties">
                    <li class="product-properties__line">
                        <div class="product-properties__key">Артикул</div>
                        <div class="product-properties__value"><?= $offer->article; ?></div>
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
                <a class="nav-item nav-link" id="nav-buy-tab" data-toggle="tab" href="#nav-buy" role="tab" aria-controls="nav-buy" aria-selected="false">Состав товара</a>
                <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Отзывы (<?= Reviews::find()->where(['product_id' => $offer->id, 'is_active' => 1, 'status_id' => Reviews::STATUS_ENABLE])->count(); ?>)</a>
            </div>
        </nav>
        <div class="tab-content product-tab-content" id="nav-tabContent">
            <div class="<?= Yii::$app->user->id == 1 ? 'default-styles' : ''; ?> tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" itemprop="description">
                <?= $offer->description ?: 'Отсутсвует'; ?>
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
                <?= ProductReviewsWidget::widget([
                    'product_id' => $offer->id

                ]); ?>
                <?= ProductReviewsFormWidget::widget([
                    'product_id' => $offer->id
                ]); ?>
            </div>
        </div>
    </div>
<?= RecomendedWidget::widget([
    'property_id' => 19,
    'product' => $offer
]); ?>

<?= AnalogWidget::widget([
    'property_id' => 21,
    'product' => $offer
]); ?>
<?= VisitedProductsWidget::widget(); ?>