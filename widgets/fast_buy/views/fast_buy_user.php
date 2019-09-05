<?

use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\tool\Policy;

?>
<?
/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */
/* @var $delivery array */
/* @var $payments array */
?>
<? Modal::begin([
    'header' => '<h2>Быстрая покупка</h2>',
    'toggleButton' => ['label' => 'Купить', 'class' => 'detail-product__buy'],
    'footer' => Html::a('Что значит \'Заказать без оплаты\' ?', '/faq/#order-not-buy'),
]); ?>

<? $form = ActiveForm::begin(); ?>
    <div >
        <div class="elem-form">
            <h2 class="checkout__title">Заказ</h2>
            <div>
                <div class="left-col" style="padding: 0 1% 0 0;">
                    <?= $form->field($order, 'delivery')->dropDownList(ArrayHelper::map($delivery, 'id', 'name'), ['prompt' => "Способ доставки"]); ?>
                </div>
                <div class="right-col" style="padding: 0;">
                    <?= $form->field($order, 'payment')->dropDownList(ArrayHelper::map($payments, 'id', 'name'), ['prompt' => "Способ оплаты"]); ?>
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
    </div>

<? ActiveForm::end(); ?>

<? Modal::end(); ?>