<?

use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\tool\Price;
use yii\helpers\Html;

/* @var $order \app\models\entity\Order */

$this->title = Title::showTitle("Заказ №" . $order->id);
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['/order/']];
$this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $order->id, 'url' => ['/order/' . $order->id . '/']];
?>
<section class="detail-order">
    <div class="detail-order-info-wrap">
        <h1 class="detail-order-info__title"><?= "Заказ №" . $order->id; ?></h1>
        <table class="detail-order-info">
            <tr>
                <td>
                    Дата покупки
                </td>
                <td>
                    <?= date("d.m.Y", $order->created_at); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Сумма заказа
                </td>
                <td>
                    <?= Price::format($order->getCash()); ?> <?= (new Currency())->show(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Статус
                </td>
                <td>
                    <?= $order->getStatus(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Оплата
                </td>
                <td>
                    <?= ($order->paid == 1)
                        ?
                        Html::tag("span", "Оплачено",['class' => 'order-paid', 'style' => 'color:#3c763d; font-weight: bold;'])
                        :
                        Html::a("Оплатить", $order->getPailink(), ['class'=>"pay-link"]); ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="detail-order-info-items-wrap">
        <? if ($items): ?>
            <h1 class="detail-order-info-items__title">Товары в заказе</h1>
            <? /* @var $item \app\models\entity\OrderItems */ ?>
            <ul class="detail-order-info-items-list">
                <? foreach ($items as $item): ?>
                <li class="detail-order-info-items-list-item">
                    <a href="<?=$item->product->detail;?>" class="detail-order-info-items-list-item__link">
                        <img class="detail-order-info-items-list-item__image" src="<?=$item->product->image?>">
                        <div class="detail-order-info-items-list-item__title">
                            <h3><?=$item->product->display?></h3>
                        </div>
                    </a>
                </li>
                <? endforeach; ?>
            </ul>
        <? else: ?>
            К сожалению вы ничего не купили
        <? endif; ?>
    </div>
</section>
