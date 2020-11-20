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
use app\modules\news\widgets\last_news\LastNewsWidget;
use app\modules\content\widgets\slider\SliderWidget;
use app\modules\site\widgets\Gruming\GrumingWidget;
use app\models\tool\seo\Title;

$this->title = Title::showTitle("Зоотовары для животных в Барнауле");
?>
<div class="page-container">
    <?= SliderWidget::widget([
        'slider_id' => 1,
    ]) ?>
    <?php if (!\app\modules\site\models\tools\Debug::isPageSpeed()): ?>
        <?= CanNowBuyWidget::widget() ?>
        <?= InformerSliderWidget::widget(); ?>
        <?= ManyPurchasedGoods::widget(); ?>
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
    <?php endif; ?>
</div>
<?php if (!\app\modules\site\models\tools\Debug::isPageSpeed()): ?>
    <?= GrumingWidget::widget(); ?>
<?php endif; ?>
<div class="page-container">
    <?php /*= LastNewsWidget::widget([
        'limit' => 3
    ]) */?>
    <?= InstagramMediaWidget::widget(); ?>
    <?= LastWeekProducts::widget(); ?>
</div>

