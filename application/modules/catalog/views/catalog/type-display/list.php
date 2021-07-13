<?php
/* @var $products \app\modules\catalog\models\entity\Offers[] */
?>

<div class="catalog-list">
    <?php foreach ($products as $product): ?>
        <?= $this->render('@app/modules/catalog/views/__item-list', [
            'product' => $product
        ]); ?>
    <?php endforeach; ?>
</div>