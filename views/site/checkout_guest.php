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
    <div class="left-col">
        <h2 class="checkout__title">Промокод</h2>
        <?= promoCartWidget::widget(); ?>
        <? $form = ActiveForm::begin(); ?>
        <div class="elem-form">
            <h2 class="checkout__title">Регистрация</h2>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($user, 'email'); ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($user, 'new_password')->passwordInput(); ?>
                </div>
            </div>
        </div>
        <div class="elem-form">
            <h2 class="checkout__title">Заказ</h2>
            <div>
                <div class="left-col" style="padding: 0 1% 0 0;">
                    <?= $form->field($order, 'delivery')->dropDownList(ArrayHelper::map($delivery, 'id', 'name'),
                        ['prompt' => "Способ доставки"]); ?>
                </div>
                <div class="right-col" style="padding: 0;">
                    <?= $form->field($order, 'payment')->dropDownList(ArrayHelper::map($payment, 'id', 'name'),
                        ['prompt' => "Способ оплаты"]); ?>
                </div>
            </div>
            <?= $form->field($order, 'comment')->textarea(); ?>
            <div class="clearfix"></div>
        </div>
        <div class="elem-form">
            <h2 class="checkout__title">Адрес доставки</h2>
            <div>
                <div class="left-col" style="padding: 0 1% 0 0;">
                    <?= $form->field($billing, 'city')->textInput(); ?>
                </div>
                <div class="right-col" style="padding: 0;">
                    <?= $form->field($billing, 'street')->textInput(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-6">
                    <?= $form->field($billing, 'home')->textInput(); ?>
                </div>
                <div class="col-md-2 col-sm-6">
                    <?= $form->field($billing, 'house')->textInput(); ?>
                </div>
                <div class="col-md-8 col-sm-6">
                    <?= $form->field($billing, 'phone'); ?>
                </div>
            </div>
        </div>

        <?= Html::submitButton('Оплатить заказ', ['class' => 'btn-main btn-green', 'value' => 'paid', 'name' => 'type']) ?>
        <?= Html::submitButton('Заказать без оплаты', ['class' => 'btn-main', 'value' => 'nopaid', 'name' => 'type']) ?>
        <?= Html::a("Персональные данные", (new Policy())->getPath(), ['class' => 'policy-link-checkout']); ?>
        <? ActiveForm::end(); ?>
    </div>
    <div class="right-col">
        <header class="total-basket-info">
            <div class="total-basket-info-wrap">
                <span>
                    <?= Yii::$app->i18n->format("{n, plural, =0{} =1{# товар} one{# товар} few{# товара} many{# товаров} other{dev}}", ['n' => Basket::count()], 'ru_RU'); ?>
                </span>
                <span>Итого: <?= Price::format((new Basket())->cash()); ?> <?= (new Currency())->show(); ?></span>
            </div>
        </header>
        <ul class="total-basket-info-list">
            <? foreach ($_SESSION['basket'] as $item): ?>
                <li class="total-basket-info-item">
                    <div class="total-basket-info-item__image">
                        <img src="<?= $item['product']->image; ?>" alt="<?= $item['product']->name; ?>"
                             title="<?= $item['product']->name; ?>">
                    </div>
                    <div class="total-basket-info-item__info">
                        <div class="total-basket-info-item__name"><?= $item['product']->name; ?></div>
                        <div class="total-basket-info-item__price-wrap">
                            <? if ($promo = (new Basket())->getPromo()): ?>
                                <div class="total-basket-info-item__price"><?= (new Currency())->show(); ?> <?= Price::format($item['product']->price - (($item['product']->price * $promo->discount / 100))); ?></div>
                            <? else: ?>
                                <div class="total-basket-info-item__price"><?= (new Currency())->show(); ?> <?= Price::format($item['product']->price); ?></div>
                            <? endif; ?>
                            <div class="total-basket-info-item__count">В корзине: <?= $item['count']; ?>шт.</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </li>
            <? endforeach; ?>

        </ul>
    </div>

    <div class="clearfix"></div>
</section>
