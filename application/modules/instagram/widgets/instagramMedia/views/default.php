<?php

use yii\helpers\StringHelper;

/* @var $media StdClass */

?>
<?php if ($media->date): ?>
    <div class="swiper-container instagram-container">
        <div class="swiper-wrapper instagram-wrapper">
			<?php foreach ($media->date as $item): ?>
                <div class="instagram__slide swiper-slide">
                    <img class="instagram__image" src="<?= $item->media_url; ?>" alt="<?= $item->caption; ?>" title="<?= $item->caption; ?>"/>
                    <a class="instagram__title" href="<?= $item->parmalink; ?>" target="_blank"><?= $item->caption; ?></a>
                </div>
			<?php endforeach; ?>
        </div>
        <div class="instagram-pagination swiper-pagination"></div>
    </div>
<?php endif; ?>
