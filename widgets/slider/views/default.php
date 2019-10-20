<?php

use yii\helpers\Html;

/* @var $images \app\models\entity\SlidersImages[] */
/* @var $use_carousel boolean */

?>
<div class="slider-index <?php echo(($use_carousel === true) ? 'owl-carousel' : ''); ?>">
    <? if ($images): ?>
        <?php foreach ($images as $image): ?>
            <div class="slider-item">
                <?php if (!empty($image->link)): ?>
                    <a href="<?php echo $image->link; ?>" target="_blank">
                <?php endif; ?>
                    <?php echo Html::img('/web/upload/' . $image->image, ['title' => $image->text, 'title' => $image->text]); ?>
                        <? if (!empty($image->text)): ?>
                            <div class="slider-item__title">Подробнее</div>
                        <? endif; ?>
                        <? if (!empty($image->description)): ?>
                            <div class="slider-item__description"><?php echo $image->description; ?></div>
                        <? endif; ?>
                <?php if (!empty($image->link)): ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <? else: ?>
        <img src="/web/upload/images/sale.png">
    <? endif; ?>
</div>

<?php
if ($use_carousel === true) {
    $JS = <<<OWL
    var news = $('.slider-index').owlCarousel({
        autoplay: true,
        autoplayTimeout: 3500,
        loop: true,
        items: 1,
        slideBy: 1,
        scrollPerPage: true,
        autoHeight: true,
        autoWeight: true
    });
OWL;

    Yii::$app->view->registerJs($JS);
}
?>
