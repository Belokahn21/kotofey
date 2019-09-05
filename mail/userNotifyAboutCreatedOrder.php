<?

use yii\helpers\Html;
use app\models\tool\Price;

/* @var $order \app\models\entity\Order */
/* @var $robokassa \app\models\tool\payments\Robokassa */
?>
    Уважаемый клиент, спасибо за покупку в нашем интернет-магазине <a href="http://eventhorizont.ru/">eventhorizont.ru</a>
    <table width="300">
        <tr>
            <td>Сумма заказа:</td>
            <td><?= Price::format($order->cash()); ?>р.</td>
        </tr>
        <tr>
            <td>Просмотреть заказ</td>
            <td><a href="https://eventhorizont.ru/order/<?= $order->id; ?>/">Ссылка на заказ</td>
        </tr>
    </table>
<? if ($order->paid == false): ?>
    <p>Так же вы можете оплатить его из этого письма нажав кнопку <strong>Оплатить</strong> ниже</p>
    <?= Html::a("Оплатить", $robokassa->generateUrl(), ['target' => '_blank', 'style' => 'color: white; background: #25d366; border: 0; display: inline-block; padding: 1% 2%; font-weight: bold; text-decoration: none;']) ?>
<? endif; ?>
