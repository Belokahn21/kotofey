<?php
/* @var $products \app\modules\catalog\models\entity\Product[] */
?>

<div class="catalog-list">
    <?php foreach ($products as $product): ?>
        <?= $this->render('@app/modules/catalog/views/__item-list', [
            'product' => $product
        ]); ?>
    <?php endforeach; ?>
</div>