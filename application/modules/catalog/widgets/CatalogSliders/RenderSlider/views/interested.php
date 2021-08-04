<?php

use app\modules\site\models\tools\PriceTool;
use app\modules\site\models\tools\Currency;
use app\modules\user\models\helpers\UserHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;

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

                    <?php
                    $render_images = [];
                    $discount = $model->getDiscountPrice();

                    if ($model->images) {
                        foreach (\yii\helpers\Json::decode($model->images) as $image) {
                            $render_images[] = [
                                'href' => $image
                            ];
                        }
                    }

                    if ($imagesFromProperty = PropertiesHelper::extractAllPropertyById($model, 23)): ?>
                        <?php foreach ($imagesFromProperty as $propertyValue): ?>
                            <?php if ($propertyValue->media):
                                $render_images[] = [
                                    'href' => $propertyValue->media->cdnData['secure_url']
                                ];
                            endif; ?>
                        <?php endforeach; ?>
                    <?php endif;


                    ?>

                    <a href="<?= ProductHelper::getDetailUrl($model); ?>" class="swiper-slide steam-slider-slide">
                        <div class="steam-slider-slide__side">
                            <img class="steam-slider-slide__image" alt="<?= $model->name; ?>" title="<?= $model->name; ?>" src="<?= ProductHelper::getImageUrl($model); ?>"/>
                        </div>
                        <div class="steam-slider-slide__side steam-slider-card">
                            <div class="steam-slider-card__title"><?= $model->name; ?></div>
                            <div class="steam-slider-images">
                                <?php if ($render_images): ?>
                                    <?php $count = 1; ?>
                                    <?php foreach ($render_images as $image): ?>
                                        <?php if ($count <= 4): ?>
                                            <div class="steam-slider-images__item"><img src="<?= $image['href']; ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>"/></div>
                                        <?php endif; ?>
                                        <?php $count++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($model->description): ?>
                                <div class="steam-slider-card__description"><?php //= StringHelper::truncateWords($model->description, 70); ?></div>
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
                            <div class="steam-slider-price-container">
                                <div class="steam-slider-price">
                                    <?php if ($discount): ?>
                                        <div class="steam-slider-price__old"><?= PriceTool::format($model->getPrice()); ?> <?= Currency::getInstance()->show(); ?></div>
                                        <div class="steam-slider-price__current"><?= PriceTool::format($discount); ?> <?= Currency::getInstance()->show(); ?></div>
                                    <?php else: ?>
                                        <div class="steam-slider-price__current"><?= PriceTool::format($model->getPrice()); ?> <?= Currency::getInstance()->show(); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="steam-slider-for">
                                    <?php $for = PropertiesHelper::extractAllPropertyById($model, 24) ?>
                                    <?php if ($for): ?>
                                        <div class="steam-slider-for__label">подходит для:
                                            <div class="steam-slider-for__group">

                                                <?php foreach ($for as $elem_val): ?>
                                                    <?php $path = null; ?>
                                                    <?php switch ($elem_val->value) {
                                                        case 241:
                                                            $path = '/images/dog.png';
                                                            break;
                                                        case 242:
                                                            $path = '/images/cat.png';
                                                            break;
                                                    }
                                                    ?>
                                                    <img class="steam-slider-for__icon" src="<?= $path; ?>"/>
                                                <?php endforeach; ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="swiper-pagination steam-slider-pagination"></div>
        </div>

        <?php $this->endCache(); endif; ?>
<?php endif; ?>
