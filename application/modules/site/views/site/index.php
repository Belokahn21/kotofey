<?php
/* @var $this yii\web\View
 * @var $providers \app\modules\catalog\models\entity\InformersValues[]
 * @var $news \app\modules\news\models\entity\News[]
 */

use app\modules\content\widgets\informers_slider\InformerSliderWidget;
use app\modules\instagram\widgets\instagramMedia\InstagramMediaWidget;
use app\modules\catalog\widgets\LastWeekProducts\LastWeekProducts;
use app\modules\catalog\widgets\DiscountItems\DiscountItemsWidget;
use app\modules\order\widgets\many_purchase\ManyPurchasedGoods;
use app\modules\catalog\widgets\CanNowBuy\CanNowBuyWidget;
use app\modules\content\widgets\slider\SliderWidget;
use app\modules\site\widgets\Gruming\GrumingWidget;
use app\models\tool\seo\Title;

$this->title = Title::showTitle("Зоотовары для животных в Барнауле");
?>
<div class="page-container">
    <?= SliderWidget::widget([
        'slider_id' => 1,
    ]) ?>
    <?= CanNowBuyWidget::widget() ?>
    <?= InformerSliderWidget::widget(); ?>
    <?= ManyPurchasedGoods::widget(); ?>
    <?php /*
    <div class="page-title__group"><h2 class="page-title">Не пропустите выгоду</h2></div>
    <div class="profit">
        <div class="profit__item"><img class="profit__image" src="/upload/images/profit1.png"></div>
        <div class="profit__item"><img class="profit__image" src="/upload/images/profit2.png">
            <a class="profit__link" href="javascript:void(0);">Подробнее</a>
        </div>
    </div>
 */ ?>
    <?= DiscountItemsWidget::widget(); ?>
    <div class="page-title__group">
        <h2 class="page-title">О нас</h2><a class="page-title__link" href="/about/">Читать дальше</a>
    </div>
    <div class="index-about-container">
        <div class="index-about">
            <?= SliderWidget::widget([
                'slider_id' => 2,
                'view' => 'square'
            ]) ?>

            <p>Барнаульский интернет-зоомагазин Котофей!</p>
            <p>Занимаемся продажей зоотоваров для домашних питомцев и доставкой зоотоваров в городе Барнаул и по России.</p>
            <p>Мы продаём сухие и влажные корма, товары для груминга, предметы интерьра такие как домики, когтеточки для кошек, лежанки<br></p>аксесуары в том числе одежда для животных, игрушки.<br><br>
            <p>Каждый месяц в нашем интернет-магазине появляются интересные акции от торговых марок <strong>Royal Canin</strong>, <strong>Hiil's</strong>, <strong>Purina</strong>. Акции содержат скидки на товары, выгодные предложения 1+1 и другие приятные условия!</p><br>
            <p>Наши клиенты имеют возможность:</p>
            <ul>
                <li>Удобно заказать зоотовары с доставкой на дом;</li>
                <li>Получить рекомендации по выбору товара;</li>
                <li>Сравнить интересующие товары через сайт;</li>
                <li>Задать вопросы оператору прямо в чате сайта;</li>
            </ul>
            <p>Наша цель - стать намного удобней чтобы покупки совершались с большим удобством и выгодой для клиента!</p>
            <p>Во время пандемии нужно сокращать походы в общественные места. Наш магазин вам поможет и в этом. Курьеры службы доставки используют средства защиты для предотвращения распространения вируса COVID-19. Если вас интересует бесконтактная доставка, то вы можете попросить оператора предоставить эту возможность при получении заказа.</p>
        </div>
    </div>
    <?php
    /*
        <div class="page-title__group is-column"><h2 class="page-title">Популярные бренды</h2>
            <a class="page-title__link" href="javascript:void(0);">Все бренды</a></div>
        <div class="brand-slider">
            <div class="brand-slider-container swiper-container">
                <div class="brand-slider-wrapper swiper-wrapper">
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/knauf.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/tytan.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/tikkurila.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/belinka.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/bosch.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/kleo.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/quelyd.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/sheetrock.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/vetonit.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/unis.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/moment.png"></div>
                    <div class="brand-slider-slide swiper-slide"><img src="/upload/images/bergauf.png"></div>
                </div>
            </div>
            <div class="brand-slider-button-next brand-slider-control"><img src="/upload/images/arrow-right-black.svg">
            </div>
            <div class="brand-slider-button-prev brand-slider-control"><img src="/upload/images/arrow-left-black.svg">
            </div>
        </div>
    */ ?>
</div>
<?= GrumingWidget::widget(); ?>
<div class="page-container">
    <?= InstagramMediaWidget::widget(); ?>
    <?= LastWeekProducts::widget(); ?>
</div>
