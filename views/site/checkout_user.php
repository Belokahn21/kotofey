<?
/* @var $this yii\web\View */
/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */

use app\models\entity\Order;
use yii\helpers\ArrayHelper;
use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\Policy;
use app\widgets\promoCart\promoCartWidget;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<section class="checkout">
    <div class="checkout-form-wrap">
        <?= $this->render('_type-order'); ?>
        <div class="checkout-form fast">
            <div class="left-col">
                <h2>Быстрый заказ</h2>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($user, 'phone'); ?>
                <?= $form->field($order, 'type')->hiddenInput(['value'=>Order::SCENARIO_FAST_ORDER, 'readonly' => true])->label(false); ?>
                <?= Html::submitButton('Сделать заказ', ['class' => 'btn-main']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="checkout-form normal">
            <div class="left-col">
                <h2 class="checkout__title">Промокод</h2>
                <?= promoCartWidget::widget(); ?>
                <? $form = ActiveForm::begin(); ?>
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
                            <?= $form->field($user, 'phone'); ?>
                        </div>
                    </div>
                </div>
                <?= Html::submitButton('Заказать', ['class' => 'btn-main', 'value' => Order::SCENARIO_SIMPLE_ORDER, 'name' => 'type']) ?>
                <?= Html::a("Персональные данные", Policy::getInstance()->getPath(), ['class' => 'policy-link-checkout']); ?>
                <? ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>