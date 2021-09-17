<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $groupedData array */
?>
<div class="modal fade" id="group-buy" tabindex="-1" role="dialog" aria-labelledby="group-buyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="group-buyLabel">Информация по покупателям (Всего: <?= count($groupedData); ?>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($groupedData): ?>
                    <ul class="group-buy">
                        <?php foreach ($groupedData as $phone => $data): ?>
                            <li class="group-buy-item-wrap">
                                <div class="group-buy-item">
                                    <a href="<?= Url::to(['order-backend/index', 'OrderSearchForm[phone]' => $phone]) ?>" class="group-buy__link js-phone-mask"><?= $phone; ?></a>
                                    <?php $card = ArrayHelper::getValue($data, 'card'); ?>
                                    <?php if ($card): ?>
                                        <div class="group-buy-item-title">
                                            <a target="_blank" href="<?= Url::to(['/admin/order/customer-backend/update', 'id' => $card->phone]); ?>"><?= $card->name ?></a>
                                            <?php switch ($card->status_id) {
                                                default :
                                                    echo '<i class="far fa-check-circle green"></i>';
//                                                    echo '<i class="fas fa-check-double green"></i>';
                                                    break;
                                            } ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (array_key_exists('group_items', $data)): ?>
                                        <?php $key = uniqid(); ?>
                                        <button data-toggle="collapse" data-target="#collapseExample-<?= $key ?>" aria-expanded="false">
                                            <span>Показать товары</span>
                                            <span>Скрыть товары</span>
                                        </button>
                                        <div class="collapse" id="collapseExample-<?= $key ?>">
                                            <ul class="group-buy-list">
                                                <?php foreach ($data['group_items']['item'] as $item): ?>
                                                    <li class="group-buy-list__item">
                                                        <?php if ($item->product): ?>
                                                            (<?= count($data['group_items']['count'][$item->product->id]); ?>) <?= Html::a($item->product->name, Url::to(['/admin/catalog/product-backend/update', 'id' => $item->product->id]), ['class' => 'group-buy-list__link']); ?>
                                                        <?php else: ?>
                                                            <?= Html::tag('div', "(" . count($data['group_items']['count'][$item->product_id]) . ") " . $item->name, ['class' => 'group-buy-list__link']); ?>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
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