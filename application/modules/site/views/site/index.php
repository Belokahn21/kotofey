<?php
/* @var $this yii\web\View
 * @var $providers \app\modules\catalog\models\entity\InformersValues[]
 * @var $news \app\modules\news\models\entity\News[]
 */

use app\modules\content\widgets\informers_slider\InformerSliderWidget;
use app\modules\instagram\widgets\instagramMedia\InstagramMediaWidget;
use app\modules\catalog\widgets\DiscountItems\DiscountItemsWidget;
use app\modules\order\widgets\many_purchase\ManyPurchasedGoods;
use app\modules\content\widgets\slider\SliderWidget;
use app\models\tool\seo\Title;

$this->title = Title::showTitle("Зоотовары для животных в Барнауле");
?>
<?= SliderWidget::widget([
    'slider_id' => 1,
]) ?>
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
<?= InstagramMediaWidget::widget(); ?>