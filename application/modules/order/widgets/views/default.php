<?php

/* @var $models \app\models\entity\Product[] */

?>
<div class="mini-catalog-wrap">
    <h2 class="homepage-providers__title">Часто покупаемые товары</h2>
    <div class="swiper-container">
        <div class="mini-catalog swiper-wrapper">
            <?php foreach ($models as $model): ?>
                <?= $this->render('__item', [
                    'model' => $model
                ]); ?>
            <?php endforeach; ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>
