
<?
/* @var $this yii\web\View */
/* @var $order \app\models\entity\Order */

/* @var $billing \app\models\entity\user\Billing */

use app\models\tool\seo\Title;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\entity\Basket;
use app\models\tool\Policy;
use app\widgets\promoCart\promoCartWidget;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<section class="checkout">
    <div class="type-order">
        <ul class="type-order-list">
            <li class="type-order-list__item">
                <div class="type-order-list__item-title">Быстрый заказ</div>
                <div class="type-order-list__item-reason">
                    <ul class="list-advantages">
                        <li class="advantage-item advantage-false">Нет бонусов</li>
                    </ul>
                </div>
            </li>
            <li class="type-order-list__item">
                <div class="type-order-list__item-title">Обычный заказ</div>
                <div class="type-order-list__item-reason">
                    <ul class="list-advantages">
                        <li class="advantage-item advantage-true">Вам начислят бонусы</li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>

    <div class="checkout-form fast">
        <? $form = ActiveForm::widget(); ?>
        <? $form = ActiveForm::widget(); ?>
        <? ActiveForm::end(); ?>
    </div>
    <div class="checkout-form normal">
        2
    </div>
</section>