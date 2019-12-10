<?php

use yii\helpers\Html;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\entity\OrdersItems;

$currency = new Currency();

/* @var $orders \app\models\entity\Order[] */
/* @var $items \app\models\entity\OrdersItems[] */
?>
<?php $this->title = Title::showTitle("Список заказов");
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['/order/']]; ?>
<section class="list-orders">
    <h1>Список заказов</h1>
	<?php if ($orders): ?>
        <table class="list-orders__table">
			<?php foreach ($orders as $order): ?>
                <tr class="list-orders__table-item">
                    <td>
                        №<?= $order->id; ?>
                        <br/>
                        <a class="list-orders__table-link" href="/order/<?= $order->id; ?>/">от <?= date("d.m.Y", $order->created_at); ?></a>
                    </td>
                    <td>
                        <table class="list-products__table">
							<?php foreach (OrdersItems::find()->where(['order_id' => $order->id])->all() as $item): ?>
								<?php if ($item->product instanceof \app\models\entity\Product): ?>
                                    <tr class="list-products__table-item" href="<?= $item->product->detail; ?>">
										<?php if (!empty($item->product->image)): ?>
                                            <td class="list-products__table-image">
                                                <img src="<?= $item->product->image; ?>">
                                            </td>
										<?php endif; ?>
                                        <td class="list-products__table-name"><?= $item->name; ?></td>
                                    </tr>
								<?php else: ?>
                                    <tr class="list-products__table-item" href="javascript:void(0);">
                                        <td class="list-products__table-image">
                                            <img src="/web/upload/images/not-image.png">
                                        </td>
                                        <td class="list-products__table-name"><?= $item->name; ?></td>
                                    </tr>
								<?php endif; ?>
							<?php endforeach; ?>
                        </table>
                    </td>
                    <td class="list-products__table-price">
						<?php if (!empty($order->cash)): ?>
							<?= Price::format($order->cash); ?>
							<?= $currency->show(); ?>
						<?php endif; ?>
                    </td>
                    <td class="list-products__table-pay">
						<?php if ($order->is_paid == false): ?>
                            <span class="red">Не оплачено</span>
						<?php else: ?>
                            <span class="green">Оплачено</span>
						<?php endif; ?>
                    </td>
                    <td>
						<?= Html::a('Подробнее', '/order/' . $order->id . '/', ['class' => 'detail-more']) ?>
                    </td>
                </tr>
			<?php endforeach; ?>
        </table>
	<?php else: ?>
        Вы ничего не покупали
	<?php endif; ?>
</section>
