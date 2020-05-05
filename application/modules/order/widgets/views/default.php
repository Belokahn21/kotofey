<?php

/* @var $models \app\models\entity\Product[] */

?>
<div class="swiper-container">
    <h2 class="homepage-providers__title">Часто покупаемые товары</h2>
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
