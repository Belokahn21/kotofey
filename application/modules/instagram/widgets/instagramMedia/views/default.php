<?php

use yii\helpers\StringHelper;

/* @var $media StdClass
 * @var $cacheTime integer
 * @var $this \yii\web\View
 */
?>
<?php if ($media !== null): ?>
    <?php if ($this->beginCache('instagramm-media-widget', ['duration' => Yii::$app->params['cache_time']])): ?>
        <div class="page-title__group is-column">
            <h2 class="page-title">Наш Instagram</h2>
            <?php /* <a class="page-title__link" href="javascript:void(0);">Все бренды</a> */ ?>
        </div>
        <div class="swiper-container instagram-container">
            <div class="swiper-wrapper instagram-wrapper">
                <?php foreach ($media->data as $item): ?>
                    <div class="instagram__slide swiper-slide">
                        <img class="instagram__image swiper-lazy" data-src="<?= @$item->media_url; ?>" alt="<?= @$item->caption; ?>" title="<?= @$item->caption; ?>"/>
                        <div class="swiper-lazy-preloader"></div>
                        <a class="instagram__title" href="<?= @$item->permalink; ?>" target="_blank"><?= @StringHelper::truncate($item->caption, 70, '...'); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $this->endCache(); ?>
    <?php endif; ?>
<?php endif; ?>

