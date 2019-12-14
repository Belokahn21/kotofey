<?php
/* @var $this yii\web\View */
/* @var $providers \app\models\entity\InformersValues[] */

/* @var $news \app\models\entity\News[] */

use app\models\entity\SiteSettings;
use app\models\tool\seo\Title;
use yii\helpers\StringHelper;
use app\widgets\slider\SliderWidget;

$this->title = Title::showTitle("Главная страница");
?>

<?= SliderWidget::widget([
	'slider_id' => 1,
	'use_carousel' => true
]) ?>

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
        <div class="advantage-description">Получаете бонусы</div>
        <i class="fas fa-gifts"></i>
    </li>
</ul>

<div class="three-line">
    <div class="social-wrap">
        <div class="block-title">Мы в социальных сетях</div>
        <ul class="social">
            <li class="social-item">
                <div class="social-item__image-wrap">
                    <img src="/web/upload/images/inst.png">
                </div>
                <div class="social-item__title">Профиль Instagramm</div>
                <div class="social-item__link">
                    <a class="social-item__link-a" href="<?= SiteSettings::getValueByCode('insta_link'); ?>" target="_blank">Перейти</a>
                </div>
            </li>
        </ul>
    </div>
    <div id="news-carousel" class="carousel slide news-index__wrap" data-ride="carousel">
        <div class="news-control">
            <div class="block-title">Новости</div>
            <div class="block-full">
                <a class="block-full__link" href="/news/">Все новости</a>
            </div>
        </div>
        <div class="carousel-inner news-index">
			<?php $news_iterator = 1; ?>
			<?php foreach ($news as $new): ?>
                <div class="carousel-item news-index__item <?= ($news_iterator == 1 ? 'active' : ''); ?>">
                    <div class="news-index__image-wrap">
                        <img class="news-index__image d-block w-100" src="/web/upload/<?= $new->preview_image; ?>" alt="<?= $new->title; ?>">
                    </div>
                    <div class="news-index__title">
                        <a href="<?= $new->getDetailurl(); ?>"><?= $new->title; ?></a>
                    </div>
                    <div class="news-index__description"><?= $new->preview; ?></div>
                </div>
				<?php $news_iterator++; ?>
			<?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#news-carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#news-carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>


<?php if ($providers): ?>
    <section>
        <div class="homepage-providers__title">В продаже известные производители товаров</div>
        <ul class="homepage-providers">
			<?php foreach ($providers as $provider): ?>
                <li class="homepage-providers__item">
                    <a class="homepage-providers__link" href="<?= $provider->link; ?>/">
                        <img class="homepage-providers__image" src="/web/upload/<?= $provider->image; ?>">
                        <div class="homepage-providers__detail">К ассортимену</div>
                    </a>
                </li>
			<?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
