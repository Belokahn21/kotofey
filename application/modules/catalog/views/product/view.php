<?php

use yii\helpers\Json;
use app\widgets\Breadcrumbs;
use app\models\tool\seo\Title;
use app\modules\stock\models\entity\Stocks;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\vendors\models\entity\Vendor;

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
            <?= AddBasketWidget::widget([
                'product_id' => $product->id,
                'price' => $product->price,
            ]); ?>
            <div class="product-info">
                <?php if ($product->count > 0): ?>
                    <div class="green"><strong>В налиии <?= $product->count; ?> шт.</strong></div>
                <?php else:
                    $nDay = date('w');

                    // условия роял канин
                    if ($product->vendor_id == Vendor::VENDOR_ID_ROYAL):
                        if (date('H') < 16 || date('i') < 30):
                            echo '<div class="green"><strong>Товар можно заказать. Доставка будет сегодня после 19.00</strong></div><br/>';
                        else:
                            echo '<div class="green"><strong>Товар можно заказать. Доставка на завтра после 19.00.</strong></div><br/>';
                        endif;
                    endif;

                    // условия хилса
                    if ($product->vendor_id == Vendor::VENDOR_ID_HILLS):
                        if (date('H') < 16 || date('i') < 50):
                            echo '<div class="green"><strong>Товар можно заказать. Доставка на завтра после 19.00</strong></div><br/>';
                        else:
                            echo '<div class="green"><strong>Товар можно заказать. Доставка на завтра после 19.00.</strong></div><br/>';
                        endif;
                    endif;

                    // условия валты
                    if ($product->vendor_id == Vendor::VENDOR_ID_VALTA):
                        if ($nDay <= 2 and date('H') < 11):
                            echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайшую среду после 19.00. ' . \Yii::t(
                                    'app',
                                    'Через {n, plural, =0{# дней} =1{# день} one{# день} few{# дней} many{# дней} other{# дней}}',
                                    ['n' => 3 - date('w')]
                                ) . '.</strong></div><br/>';
                        else:
                            echo '<div class="green"><strong>Товар можно заказать. Доставка в следующую среду после 19.00.</strong></div><br/>';
                        endif;
                    endif;

                    // условия форзы
                    if ($product->vendor_id == Vendor::VENDOR_ID_FORZA):
                        if (date('w') >= 2):
                            echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайшую пятницу.</strong></div><br/>';
                        elseif (date('w') >= 5):
                            echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайший вторник.</strong></div><br/>';
                        endif;
                    endif;

                    // условия Пурины
                    if ($product->vendor_id == Vendor::VENDOR_ID_PURINA):
                        if ($nDay == 0 || $nDay == 6):
                            echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайшую среду.</strong></div><br/>';
                        else:
                            if ($nDay >= 5):
                                echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайшую среду.</strong></div><br/>';
                            elseif ($nDay >= 2 && date('H') > 17):
                                echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайшую пятницу.</strong></div><br/>';
                            else:
                                echo '<div class="green"><strong>Товар можно заказать. Доставка в ближайшую среду.</strong></div><br/>';
                            endif;
                        endif;
                    endif;

                    // для всех остальных (мясоешки, сибагро)
                    if (in_array($product->vendor_id, [Vendor::VENDOR_ID_SIBAGRO, Vendor::VENDOR_ID_TAVELA])):
                        echo '<div class="green"><strong>Товар можно заказать. Доставка на завтра после 19.00.</strong></div><br/>';
                    endif;

                endif;
                ?>

                <div class="product-info__title">При заказе на сумму от 500 рублей бесплатная доставка по городу Барнаул</div>
                <div class="product-info__note">Доставляем по городу Барнаулу, поселки: Власиха, Лесной, Центральный, Южный, Авиатор, Спутник.<br/>Доставка в Новоалтайск, Казеную заимку, Гоньбу, Научный городок +150 рублей к любой сумме заказа<br/>Доставка в ЗАТО Сибирский +300 рублей к любой сумме заказа<br/>Для доставки в другие точки уточняйте по телефону<strong><a class="js-phone-mask" style="color: black;" href="tel:1"></a></strong></div>
                <br/>
                <div class="product-info__title">Время доставки</div>
                <div class="product-info__note">Заказы доставляются каждый день после 19.00. Доставка в выходные только при заказе с понедельника по пятницу!</div>
            </div>
            <?php if ($properties): ?>
                <ul class="product-properties">
                    <li class="product-properties__line">
                        <div class="product-properties__key">Артикул</div>
                        <div class="product-properties__value"><?= $product->article; ?></div>
                    </li>
                    <?php foreach ($properties as $property): ?>
                        <li class="product-properties__line">
                            <div class="product-properties__key"><?= $property->property->name; ?></div>
                            <div class="product-properties__value"><?= $property->finalValue; ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php /*
        <ul class="collapse product-properties" id="collapseExample">
            <li class="product-properties__line">
                <div class="product-properties__key">Артикул товара</div>
                <div class="product-properties__value">0525052</div>
            </li>
        </ul>
        <a class="product-properties__more" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Все характеристики</a>
 */ ?>
        </div>
    </div>
    <nav class="product-tabs in-product">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Описание</a>
            <!--            <a class="nav-item nav-link" id="nav-characteristics-tab" data-toggle="tab" href="#nav-characteristics" role="tab" aria-controls="nav-characteristics" aria-selected="false">Характеристики</a>-->
            <!--            <a class="nav-item nav-link" id="nav-recommendations-tab" data-toggle="tab" href="#nav-recommendations" role="tab" aria-controls="nav-recommendations" aria-selected="false">Рекомендации</a>-->
            <a class="nav-item nav-link" id="nav-delivery-tab" data-toggle="tab" href="#nav-delivery" role="tab" aria-controls="nav-delivery" aria-selected="false">Доставка</a>
            <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="false">Оплата</a>
            <a class="nav-item nav-link" id="nav-buy-tab" data-toggle="tab" href="#nav-buy" role="tab" aria-controls="nav-buy" aria-selected="false">Как купить?</a>
            <a class="nav-item nav-link" id="nav-available-tab" data-toggle="tab" href="#nav-available" role="tab" aria-controls="nav-available" aria-selected="false">Наличие в магазинах</a>
        </div>
    </nav>
    <div class="tab-content product-tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" itemprop="description">
            <?= $product->description ?: 'Отсутсвует'; ?>
        </div>
        <div class="tab-pane fade" id="nav-delivery" role="tabpanel" aria-labelledby="nav-delivery-tab">
            <strong>Бесплатная доставка при заказе от 500 рублей</strong><br>
            Доставляем по городу Барнаулу, поселки: Власиха, Лесной, Центральный, Южный, Авиатор, Спутник.<br>
            Доставка в Новоалтайск, Казеную заимку, Гоньбу, Научный городок +150 рублей к любой сумме заказа<br>
            Доставка в ЗАТО Сибирский +300 рублей к любой сумме заказа<br>
            Для доставки в другие точки уточняйте по телефону <strong><a style="color: black;" class="js-phone-mask" href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>"><?= SiteSettings::getValueByCode('phone_1'); ?></a></strong>
            <br/><br/><strong>Время доставки: следующий день после 19.00 - заказывайте заранеее!</strong>
        </div>
        <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
            <strong>Оплатить можно:</strong>
            <ul>
                <li>Наличными;</li>
                <li>Переводом на карту банка (Сбербанк онлайн).</li>
            </ul>
            <i>*Оплата только при получении заказа</i>
        </div>
        <div class="tab-pane fade" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">
            Для покупки товаров на нашем сайте вам нужно добавить интересующий вас товар в корзину и пройти к оформлению заказа.<br>
            После того как заказ был оформлен с вами свяжется оператор (через 15 минут) для уточнения деталей заказа и согласования времени доставки.
        </div>
        <div class="tab-pane fade" id="nav-available" role="tabpanel" aria-labelledby="nav-available-tab">
            <?php if ($product->status_id == Product::STATUS_ACTIVE && $product->count > 0): ?>
                <ul class="in-stock-detail-product">
                    <?php foreach (Stocks::find()->where(['active' => 1])->all() as $stock) : ?>
                        <li class="in-stock-detail-product__item"><?= $stock->name; ?> (<?= $stock->address; ?>) - <span class="green">Товар в наличии. Возможна доставка сегодня/самовывоз</span></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <?php if ($product->status_id == Product::STATUS_ACTIVE):

                    if ($product->vendor_id == Vendor::VENDOR_ID_ROYAL):
                        if (date('H') < 16 || date('i') < 30):
                            echo '<span class="green"><strong>Товар можно заказать. Доставка будет сегодня после 19.00</strong></span>';
                        else:
                            echo '<span class="green"><strong>Товар можно заказать. Доставка на следующий день.</strong></span>';
                        endif;
                    endif;

                    if ($product->vendor_id == Vendor::VENDOR_ID_HILLS):
                        if (date('H') < 16 || date('i') < 50):
                            echo '<span class="green"><strong>Товар можно заказать. Доставка на завтра после 19.00</strong></span>';
                        else:
                            echo '<span class="green"><strong>Товар можно заказать. Доставка на следующий день.</strong></span>';
                        endif;
                    endif;

                else: ?>
                    <span class="red"><strong>Товара нет в наличии</strong></span>
                <?php endif ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /*
<div class="page-title__group is-column"><h2 class="page-title">Выгодные предложения</h2><a class="page-title__link" href="javascript:void(0);">Все предложения</a></div>
<div class="swiper-container vitrine-container">
    <div class="swiper-wrapper vitrine-wrapper">
        <div class="swiper-slide vitrine__slide">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick1.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
        <div class="swiper-slide vitrine__slide">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick2.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
        <div class="swiper-slide vitrine__slide active">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick3.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
        <div class="swiper-slide vitrine__slide">
            <div class="discount">- 15%</div>
            <img src="/upload/images/brick4.png">
            <div class="vitrine__title">Кирпич строительный красный (черновой) пустотелый</div>
            <div class="vitrine__properties">
                <ul class="light-properties">
                    <li class="light-properties__item">
                        <div class="light-properties__label">Размер</div>
                        <div class="light-properties__value">250*120*65мм</div>
                    </li>
                    <li class="light-properties__item">
                        <div class="light-properties__label">Артикул</div>
                        <div class="light-properties__value">0525052</div>
                    </li>
                </ul>
            </div>
            <div class="vitrine__price"><span class="amount-old">10.90</span><span class="amount">6.90</span><span class="rate">Р / шт</span></div>
            <button class="is-white add-basket js-add-basket" type="button"><img class="add-basket__icon" src="/upload/images/basket.png"><span class="add-basket__label">В корзину</span></button>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>
 */ ?>
