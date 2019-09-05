<?

use yii\helpers\Html;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\tool\Currency;

$currency = new Currency();

/* @var $orders \app\models\entity\Order */
?>
<? $this->title = Title::showTitle("Список заказов");
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['/order/']];?>
<section class="list-orders">
    <h1>Список заказов</h1>
    <?if($orders):?>
    <table class="list-orders__table">
        <? foreach ($orders as $order): ?>
            <tr class="list-orders__table-item">
                <td>
                    №<?= $order->id; ?>
                    <br/>
                    <a class="list-orders__table-link" href="/order/<?= $order->id; ?>/">от <?= date("d.m.Y", $order->created_at); ?></a>
                </td>
                <td>
                    <table class="list-products__table">
                        <? foreach ($order->items as $item): ?>
                            <tr class="list-products__table-item" href="<?=$item->detail;?>">
                                <td class="list-products__table-image"><img src="<?= $item->image; ?>"></td>
                                <td class="list-products__table-name"><?= $item->name; ?></td>
                            </tr>
                        <? endforeach; ?>
                    </table>
                </td>
                <td class="list-products__table-price">
                    <? if (!empty($order->cash)): ?>
                        <?= Price::format($order->cash); ?>
                        <?= $currency->show(); ?>
                    <? endif; ?>
                </td>
                <td class="list-products__table-pay">
                    <? if ($order->paid == false): ?>
                        <?= Html::a('Оплатить', $order->pailink, ['class' => 'btn-pay']); ?>
                    <? else: ?>
                        <span style="color:#3c763d;">Оплачено</span>
                    <? endif; ?>
                </td>
                <td>
                    <?= Html::a('Подробнее', '/order/' . $order->id . '/', ['class' => 'detail-more']) ?>
                </td>
            </tr>
        <? endforeach; ?>
    </table>
    <?else:?>
    Вы ничего не покупали
    <?endif;?>
</section>
