<?
/* @var $this yii\web\View */
/* @var $providers \app\models\entity\Providers[] */

/* @var $news \app\models\entity\News[] */

use app\models\entity\SiteSettings;
use app\models\tool\seo\Title;
use yii\helpers\StringHelper;
use app\widgets\slider\SliderWidget;

$this->title = Title::showTitle("Главная страница");
?>

<?php echo SliderWidget::widget([
    'slider_id' => 1,
    'use_carousel' => true
]) ?>

<div class="edge">
    <ul>
        <li>
            <img src="https://image.flaticon.com/icons/svg/664/664468.svg">
            <p>Быстрая доставка</p>
        </li>
        <li>
            <img src="https://image.flaticon.com/icons/svg/1524/1524983.svg">
            <p>Удобные заказы</p>
        </li>
        <li>
            <img src="/web/upload/images/fire.png">
            <p>Популярные бренды</p>
        </li>
        <li>
            <img src="https://image.flaticon.com/icons/svg/45/45925.svg">
            <p>Широкий ассортимент</p>
        </li>
        <li>
            <img src="https://image.flaticon.com/icons/svg/1611/1611260.svg">
            <p>Низкие цены</p>
        </li>
    </ul>
</div>

<div class="test">
    <div class="index_about">
        <h2>Наши поставщики</h2>
        <ul class="list-providers owl-carousel">
            <?php foreach ($providers as $provider): ?>
                <li class="provider_item">
                    <div class="provider_item-image-wrap">
                        <img src="/web/upload/<?php echo $provider->image; ?>" alt="<?php echo $provider->name; ?>" title="<?php echo $provider->name; ?>">
                    </div>
                    <div class="provider_item__title">
                        <?php if ($provider->link): ?>
                            <a href="<?php echo $provider->link ?>" target="_blank">
                                <?php echo $provider->name; ?>
                            </a>
                        <?php else: ?>
                            <?php echo $provider->name; ?>
                        <?php endif; ?>
                    </div>
                    <div class="provider_item__desc"><?php echo StringHelper::truncate($provider->description, 250,
                            '...') ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="me-inst">
        <h2>Мы в Instagramm</h2>
        <a href="<?= SiteSettings::getValueByCode('insta_link'); ?>" rel="nofollow" target="_blank">
            <img src="/web/upload/images/inst.png"></a>
        <div class="me-inst-block-link">
            <a href="<?= SiteSettings::getValueByCode('insta_link'); ?>" rel="nofollow" target="_blank"
               class="me-inst-link">Перейти</a>
        </div>
    </div>

    <div class="index-search">
        <div class="news-head-panel">
            <h2>Новости</h2>
            <a href="/news/">Все новости</a>
        </div>
        <ul class="list-news owl-carousel">
            <?php foreach ($news as $new): ?>
                <li class="list-news__item">
                    <a class="list-news__item-link" href="<?php echo $new->detailurl; ?>">
                        <?php if ($new->preview_image): ?>
                            <div class="list-news__item-wrap-image">
                                <img class="list-news__item-image" src="/web/upload/<?php echo $new->preview_image; ?>" title="<?php echo $new->title; ?>" alt="<?php echo $new->title; ?>">
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="list-news__item-title"><?php echo $new->title; ?></div>
                    <div class="list-news__item-preview"><?php echo $new->preview; ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>