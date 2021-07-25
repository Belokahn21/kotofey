<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use app\modules\user\models\helpers\UserHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\OperatorAdmin\OperatorAdminWidget;

/* @var $this \yii\web\View
 * @var $orderQuery \yii\db\ActiveQuery
 * @var $user \app\modules\user\models\entity\User
 * @var $filterModel \app\modules\order\models\forms\OperatorReportFilterForm
 */

$this->title = Title::show('Кабинет оператора');
?>
<div class="title-group">
    <h1>Добро пожаловать, <?= UserHelper::getFullName($user); ?></h1>
</div>
<?= OperatorAdminWidget::widget(); ?>
<?php $form = ActiveForm::begin([
    'method' => 'get'
]); ?>
<div class="row">
    <div class="col-4"><?= $form->field($filterModel, 'start_at')->textInput(['class' => 'js-datepicker form-control']); ?></div>
    <div class="col-4"><?= $form->field($filterModel, 'end_at')->textInput(['class' => 'js-datepicker form-control']); ?></div>
    <div class="col-4"><?= $form->field($filterModel, 'manager_id')->dropDownList(ArrayHelper::map(UserHelper::getManagers(), 'id', 'email'), ['class' => 'js-datepicker form-control']); ?></div>
</div>
<?= Html::submitButton('Получить отчёт', ['class' => 'btn-main']) ?>
<?= Html::a('Очистить', Url::to(['index']), ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>

<ul>
    <li>Всего обработано заказов: <?= $orderQuery->count(); ?></li>
    <li>
        Прибыль за месяц:
        <?php
        $result_summ = 0;
        foreach ($orderQuery->where(['is_closed' => true, 'is_paid' => true])->all() as $order) {
            $result_summ += OrderHelper::orderSummary($order);
        }

        echo Price::format($result_summ) . '/<span class="green">' . Price::format(round($result_summ * 0.05)) . '</span>'
        ?>
    </li>
</ul>
<?php foreach ($orderQuery->all() as $order): ?>
    <div class="row">
        <div class="col-3"><?= Html::a('Заказ № ' . $order->id, Url::to(['order-backend/update', 'id' => $order->id])) ?></div>
        <div class="col-3"><?= Price::format(OrderHelper::orderSummary($order)); ?><?= Currency::getInstance()->show(); ?></div>
        <div class="col-3"><?= date('d.m.Y H:i:s', $order->created_at); ?></div>
        <div class="col-3"><?= $order->email ? $order->email . '/' : null; ?><?= $order->phone; ?></div>
    </div>
<?php endforeach; ?>


<div class="operator-calculator-react"></div>