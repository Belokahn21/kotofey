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
                <div class="swiper-slide swiper-instagram__slide">
                    <img class="swiper-instagram__image" src="<?= $mediaItem->media_url; ?>">
                    <a class="swiper-instagram__link" href="<?= $mediaItem->permalink; ?>" target="_blank"><?= @($mediaItem->caption ? $mediaItem->caption : "Без названия"); ?></a>
                </div>
			<?php endforeach; ?>
        </div>
        <!--        <div class="swiper-instagram-pagination"></div>-->
    </div>
</div>