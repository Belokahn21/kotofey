<?php

use yii\helpers\StringHelper;
use app\modules\user\models\helpers\UserHelper;
use app\modules\catalog\models\helpers\ProductHelper;

/* @var $models \app\modules\catalog\models\entity\Product[]
 * @var $this \yii\web\View
 * @var $title string
 * @var $subTitle string
 * @var $link string
 * @var $linkTitle string
 * @var $uniqKey string
 */

?>

<?php if ($models): ?>
    <?php if ($this->beginCache('many-purchase-items-widget-interested', ['duration' => 3600 * 24 * 7])): ?>
        <div class="page-title__group">
            <h2 class="page-title"><?= $title; ?></h2>

            <?php if (!empty($subTitle)): ?>
                <div class="page-title__note"><?= $subTitle; ?></div>
            <?php endif; ?>

            <?php if (!empty($link) && !empty($linkTitle)): ?>
                <a class="page-title__link" href="<?= $link; ?>"><?= $linkTitle; ?></a>
            <?php endif; ?>
        </div>
        <div class="swiper-container steam-slider-container">
            <div class="swiper-wrapper steam-slider-wrapper">
                <?php foreach ($models as $model): ?>
                    <a href="<?= ProductHelper::getDetailUrl($model); ?>" class="swiper-slide steam-slider-slide">
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

                            <?php if ($model->comments): ?>

                                <?php $commentarie = $model->comments[0]; ?>

                                <div class="steam-slider-review">
                                    <div class="steam-slider-review__avatar"><img class="steam-slider-review__avatar-image" src="<?= UserHelper::getAvatar($commentarie->author); ?>"/></div>
                                    <div class="steam-slider-review__body">
                                        <div class="steam-slider-review__text">
                                            <div class="steam-slider-review__author"><?= $commentarie->author->email; ?></div>
                                            <div class="steam-slider-review__message">говорит, <?= $commentarie->text; ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="swiper-pagination steam-slider-pagination"></div>
        </div>

        <?php $this->endCache(); endif; ?>
<?php endif; ?>
