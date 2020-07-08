<?php
/* @var $media StdClass */
?>
<div class="instagram-media">
    <div class="instagram-media__info">
        <h2 class="homepage-providers__title">Наша Instagram страница</h2>
    </div>
    <div class="swiper-container swiper-instagram-container">
        <div class="swiper-wrapper">
			<?php foreach ($media->data as $mediaItem): ?>
				<?php $title = @($mediaItem->caption ? \yii\helpers\StringHelper::truncate($mediaItem->caption, 40, '...') : "Без названия"); ?>
                <div class="swiper-slide swiper-instagram__slide">
                    <img class="swiper-instagram__image" src="<?= $mediaItem->media_url; ?>">
                    <a title="<?= $title; ?>" class="swiper-instagram__link" href="<?= $mediaItem->permalink; ?>" target="_blank">
						<?= $title; ?>
                    </a>
                </div>
			<?php endforeach; ?>
        </div>
        <!--        <div class="swiper-instagram-pagination"></div>-->
    </div>
</div>