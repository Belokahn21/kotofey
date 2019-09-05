<?

use app\models\entity\OrderStatus;
use app\models\entity\OrderItems;
use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use app\models\entity\User;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\Price;
use app\models\tool\Currency;

/* @var $model \app\models\entity\Order */

$this->title = Title::showTitle("Заказ №" . $model->id); ?>
<section class="new-order-block">
    <? $form = ActiveForm::begin(); ?>
    <div class="left-col">
        <h1 class="title">Заказ №<?=$model->id;?></h1>
        <br />
        <?= Html::a("Назад", '/admin/order/', ['class' => 'btn-back']) ?>
        <h3 class="title">Информация о заказе</h3>
        <div style="margin: 1% 0; color: green; font-weight: bold; border: 1px #e2e2e2 solid; display: inline-block; padding: 1%; -webkit-border-radius: 0.2em;-moz-border-radius: 0.2em;border-radius: 0.2em;">Сумма заказа: <?=Price::format($model->cash());?><?=(new Currency())->show();?></div>
        <div class="new-order-info">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(OrderStatus::find()->all(), 'id', 'name'), ['prompt' => 'Статус заказа']); ?>
            <?= $form->field($model, 'payment')->dropDownList(ArrayHelper::map(Payment::find()->all(), 'id', 'name'), ['prompt' => 'Способ оплаты']); ?>
            <?= $form->field($model, 'delivery')->dropDownList(ArrayHelper::map(Delivery::find()->all(), 'id', 'name'), ['prompt' => 'Способ доставки']); ?>
        </div>
        <?= $form->field($model, 'paid')->radioList(array("Не оплачено", "Оплачено")); ?>
        <?= $form->field($model, 'comment')->textarea(); ?>
        <h3 class="title">Покупатель</h3>
        <?= $form->field($model, 'user')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'name'),['prompt' => 'Покупатель']); ?>

    </div>
    <div class="right-col">
        <h3 class="title">Товары в заказе</h3>
        <? $model->product_id = ArrayHelper::getColumn(OrderItems::find()->select('productId')->where(['orderId'=>$model->id])->all(), 'productId'); ?>
        <?= $form->field($model, 'product_id')->widget('\app\widgets\SelectProductDropdown')->label(false) ?>
    </div>
    <div class="clearfix"></div>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
    <? ActiveForm::end(); ?>
</section>