<?php

/* @var $product_id integer */

echo $this->render('modal/buy-weight', [
    'product_id' => $product_id,
    'model' => $model,
]);
?>
<div class="product-button" data-toggle="modal" data-target="#buy-as-weight">
    Купить на разнавес
</div>