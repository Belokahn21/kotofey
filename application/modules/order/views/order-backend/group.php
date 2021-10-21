<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $groupedData array */

$this->title = \app\modules\seo\models\tools\Title::show('Группированные продажи');
?>
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
