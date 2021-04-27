<?php

use yii\helpers\StringHelper;
use app\modules\catalog\models\helpers\ProductHelper;

/* @var $models \app\modules\catalog\models\entity\Product[] */

?>

<?php if ($models): ?>
    <?php if ($this->beginCache('many-purchase-items-widget-interested', ['duration' => 3600 * 24 * 7])): ?>

        <div class="swiper-container steam-slider-container">
            <div class="swiper-wrapper steam-slider-wrapper">
                <?php foreach ($models as $model): ?>
                    <div class="swiper-slide steam-slider-slide">
                        <div class="steam-slider-slide__side"><img class="steam-slider-slide__image" alt="<?= $model->name; ?>" title="<?= $model->name; ?>" src="<?= ProductHelper::getImageUrl($model); ?>"/></div>
                        <div class="steam-slider-slide__side steam-slider-card">
                            <div class="steam-slider-card__title"><?= $model->name; ?></div>
                            <div class="steam-slider-images">
                                <?php if ($model->images): ?>
                                    <?php $count = 1; ?>
                                    <?php foreach (\yii\helpers\Json::decode($model->images) as $image): ?>
                                        <?php if ($count <= 4): ?>
                                            <div class="steam-slider-images__item"><img src="<?= $image; ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>"/></div>
                                        <?php endif; ?>
                                        <?php $count++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($model->description): ?>
                                <div class="steam-slider-card__description"><?= StringHelper::truncate($model->description, 200); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php $this->endCache(); endif; ?>
<?php endif; ?>
