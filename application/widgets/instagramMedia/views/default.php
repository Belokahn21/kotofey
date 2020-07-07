<?php
/* @var $media StdClass */
?>

<div class="swiper-container swiper-instagram-container">
    <div class="swiper-wrapper">
		<?php foreach ($media->data as $mediaItem): ?>
            <div class="swiper-slide">
                <img src="<?= $mediaItem->media_url; ?>">
            </div>
		<?php endforeach; ?>
    </div>
    <div class="swiper-instagram-pagination"></div>
</div>
