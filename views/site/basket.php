<?
/* @var $this yii\web\View */
/* @var $products \app\models\entity\Product */

/* @var $currency Currency */

use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\models\tool\Currency;
use yii\helpers\Html;
use app\models\entity\Basket;

$this->title = Title::showTitle("Корзина товаров");
$this->params['breadcrumbs'][] = ['label' => 'Корзина товаров', 'url' => ['/basket/']];
?>
<section class="basket">
    <h1>Корзина товаров</h1>
    <? if (Basket::count() > 0): ?>
        <?= Html::a('Очистить корзину', "/clear/", ['class' => 'btn-main grey']); ?>
        <?= Html::a('Оформить заказ', "/checkout/", ['class' => 'btn-main']); ?>
    <? endif; ?>
	<? if (!empty(Yii::$app->session->get('basket'))): ?>
        <div class="cart-wrap">
            <ul class="cart-list-items">
                <? foreach ((new Basket())->listItems() as $item): ?>
                    <li class="cart-list-item">
                        <img src="<?= $item->product->image ?>" title="<?= $item->product->name ?>" alt="<?= $item->product->name ?>">
                        <div class="cart-list-item__title"><?= $item->product->name ?></div>
                        <div class="cart-list-item__calc">
                            <form class="cart-list-item__calc-form">
                                <i class="fas fa-minus" data-id="<?=$item->product->id;?>"></i> <input size="1" class="cart-list-item__calc-count" name="count" placeholder="1" value="<?=$item->count;?>"> <i class="fas fa-plus" data-id="<?=$item->product->id;?>"></i>
                            </form>
                            <div class="cart-list-item__calc-summ"><span><?=Price::format($item->product->price*$item->count);?></span> <?=(new Currency())->show();?></div>
                        </div>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
    <? else: ?>
        Ничего не выбрано
    <? endif; ?>
</section>
