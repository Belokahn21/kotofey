<?php

use app\modules\catalog\models\entity\ProductPropertiesValues;

/* @var $providers \yii\db\ActiveQuery */

?>
<?php if ($this->beginCache('providers-cache', ['duration' => 3600 * 24 * 7])): ?>
    <div class="companies-wrap">
        <h2 class="homepage-providers__title">В продаже корма для животных известных производителей зоотоваров</h2>
        <div class="swiper-container">
            <ul class="companies swiper-wrapper">
				<?php foreach ($providers->all() as $provider): ?>
                    <li class="companies__item swiper-slide">
                        <img class="companies__image" src="/upload/<?= $provider->image; ?>" alt="<?= $provider->name; ?>" title="<?= $provider->name; ?>">
                        <a href="<?= $provider->link; ?>" class="companies__link">К ассортименту (<?= ProductPropertiesValues::find()->where(['value' => $provider->id])->count('product_id'); ?>)</a>
                    </li>
				<?php endforeach; ?>
            </ul>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
	<?php $this->endCache(); ?>
<?php endif; ?>