<?php
/* @var $product_id integer
 * @var $count integer
 */
?>
<button class="add-basket js-add-basket" type="button" data-product-id="<?= $product_id; ?>" data-product-count="<?= $count; ?>">
    <img class="add-basket__icon" src="/upload/images/basket.png"/><span class="add-basket__label">В корзину</span>
</button>