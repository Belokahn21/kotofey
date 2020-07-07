<?php
/* @var $this yii\web\View
 * @var $providers \app\modules\catalog\models\entity\InformersValues[]
 * @var $news \app\modules\news\models\entity\News[]
 */

use app\modules\order\widgets\ManyPurchasedGoods;
use app\modules\site_settings\models\entity\SiteSettings;
use app\models\tool\seo\Title;
use app\modules\news\widgets\last_news\LastNewsWidget;
use app\widgets\slider\SliderWidget;
use app\widgets\informers_slider\InformerSliderWidget;
use app\modules\bonus\models\services\BonusByBuyService;
use app\widgets\instagramMedia\InstagramMediaWidget;

$this->title = Title::showTitle("Зоотовары для животных в Барнауле");
?>

<?= SliderWidget::widget([
	'slider_id' => 1,
	'use_carousel' => true
]) ?>
<?= InformerSliderWidget::widget(); ?>
<?= ManyPurchasedGoods::widget(); ?>
    <ul class="advantages">
        <li class="advantages-item">
            <div class="advantage-title">Делаете заказ</div>
            <div class="advantage-description">Большой выбор товаров и низкие цены</div>
            <i class="fas fa-shopping-cart"></i>
        </li>
        <li class="advantages-item">
            <div class="advantage-title">Мы доставляем заказ</div>
            <div class="advantage-description">Доставка в течении дня</div>
            <i class="fas fa-truck"></i>
        </li>
        <li class="advantages-item">
            <div class="advantage-title">Получаете заказ</div>
            <div class="advantage-description"><?= (BonusByBuyService::isActive() ? "Бонусы за покупку" : "И удовольствие"); ?></div>
            <i class="fas fa-gifts"></i>
        </li>
    </ul>

    <div class="three-line">
		<?= SliderWidget::widget([
			'slider_id' => 2,
			'use_carousel' => true,
			'view' => 'square'
		]) ?>
    </div>
<?= InstagramMediaWidget::widget(); ?>
<?= LastNewsWidget::widget(); ?>