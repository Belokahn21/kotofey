<?php
/* @var $product \app\modules\catalog\models\entity\Product
 * @var $showOrderButton boolean
 */
?>
<div class="product-status wait">
    <div>Ожидается поступление</div>

    <?php if ($showOrderButton): ?>
        <button type="button" class="product-status__notify" data-target="#notifyPickup<?= $product->id; ?>" data-toggle="modal">Уведомить о поступлении</button>
        <!-- Modal -->
        <div class="modal fade" id="notifyPickup<?= $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="notifyPickup<?= $product->id; ?>Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notifyPickup<?= $product->id; ?>Label">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>