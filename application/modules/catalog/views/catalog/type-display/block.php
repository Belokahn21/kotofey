<?php
/* @var $products \app\modules\catalog\models\entity\Offers[] */
?>

<ul class="catalog">
    <?php foreach ($products as $product): ?>
        <?= $this->render('@app/modules/catalog/views/__item-block', [
            'product' => $product
        ]); ?>
    <?php endforeach; ?>
</ul>