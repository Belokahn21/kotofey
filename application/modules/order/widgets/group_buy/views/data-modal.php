<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $groupedData array */
?>
<div class="modal fade" id="group-buy" tabindex="-1" role="dialog" aria-labelledby="group-buyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="group-buyLabel">Информация по покупателям</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($groupedData): ?>
                    <ul class="group-buy">
                        <?php foreach ($groupedData as $phone => $data): ?>
                            <li class="group-buy__item">
                                <a href="tel:<?= $phone; ?>" class="group-buy__link phone-mask"><?= $phone; ?></a>
                                <?php if ($data['group_items']): ?>
                                    <ul class="group-buy-list">
                                        <?php foreach ($data['group_items']['item'] as $item): ?>
                                            <li class="group-buy-list__item">
                                                <?php if ($item->product): ?>
                                                    (<?= count($data['group_items']['count'][$item->product->id]); ?>)<?= Html::a($item->product->name, Url::to(['/']), ['class' => 'group-buy-list__link']); ?>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>