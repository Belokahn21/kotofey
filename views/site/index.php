<?
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
    <div id="provider-carousel" class="carousel slide providers-wrap" data-ride="carousel">
        <div class="block-title">Наши поставщики</div>
        <div class="carousel-inner providers">
			<?php $provider_iterator = 1; ?>
			<?php foreach ($providers as $provider): ?>
                <div class="carousel-item provider-item <?= ($provider_iterator == 1 ? 'active' : ''); ?>">
                    <div class="provider-item__image-wrap">
                        <img class="d-block w-100" src="/web/upload/<?= $provider->image; ?>" alt="First slide">
                    </div>
                    <div class="provider-item__title"><a href='/brands/<?= $provider->id; ?>/'><?= $provider->name; ?></a></div>
                    <div class="provider-item__description"><?= $provider->description; ?></div>
                </div>
				<?php $provider_iterator++; ?>
			<?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
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
    <div id="news-carousel" class="carousel slide providers-wrap" data-ride="carousel">
        <div class="news-control">
            <div class="block-title">Новости</div>
            <div class="block-full">
                <a class="block-full__link" href="/news/">Все новости</a>
            </div>
        </div>
        <div class="carousel-inner providers">
			<?php $news_iterator = 1; ?>
			<?php foreach ($news as $new): ?>
                <div class="carousel-item provider-item <?= ($news_iterator == 1 ? 'active' : ''); ?>">
                    <div class="provider-item__image-wrap">
                        <img class="d-block w-100" src="/web/upload/<?= $new->preview_image; ?>" alt="First slide">
                    </div>
                    <div class="provider-item__title"><a href="<?= $new->getDetailurl(); ?>"><?= $new->title; ?></a></div>
                    <div class="provider-item__description"><?= $new->preview; ?></div>
                </div>
				<?php $news_iterator++; ?>
			<?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>