<?php
/* @var $this yii\web\View */
/* @var $providers \app\models\entity\InformersValues[] */

/* @var $news \app\models\entity\News[] */

use app\models\entity\SiteSettings;
use app\models\tool\seo\Title;
use yii\helpers\Url;
use app\widgets\slider\SliderWidget;

$this->title = Title::showTitle("зоотовары для животных в Барнауле");
?>

<?= SliderWidget::widget([
    'slider_id' => 1,
    'use_carousel' => true
]) ?>

<?php if ($providers): ?>
    <section>
        <div class="homepage-providers__title">В продаже корма для животных известных производителей зоотоваров</div>
        <ul class="homepage-providers">
			<?php foreach ($providers as $provider): ?>
                <li class="homepage-providers__item">
                    <a class="homepage-providers__link" href="<?= $provider->link; ?>">
                        <img class="homepage-providers__image" src="/web/upload/<?= $provider->image; ?>" title="<?= $provider->name; ?>" alt="<?= $provider->name; ?>">
                        <div class="homepage-providers__detail">К ассортимену</div>
                    </a>
                </li>
			<?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>

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

<div class="index-news__wrap">
    <h2 class="homepage-providers__title">Интересные новости</h2>
    <ul class="index-news">
        <?php foreach ($news as $new): ?>
            <li class="index-news__item">
                <a href="<?= Url::to(['/news/' . $new->slug . '/']); ?>" class="index-news__link">
                    <img src="/web/upload/<?= $new->preview_image; ?>" class="index-news__image">
                </a>
                <a href="<?= Url::to(['/news/' . $new->slug . '/']); ?>" class="index-news__link">
                    <h3 class="index-news__title"><?= $new->title; ?></h3>
                </a>
                <div class="index-news__preview">
                    <?= $new->preview; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="index-news__control">
        <a class="index-news__control-link" href="<?= Url::to(['site/news']); ?>">Читать больше</a>
    </div>
</div>

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
</div>