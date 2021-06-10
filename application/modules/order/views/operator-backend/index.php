<?php

use app\modules\seo\models\tools\Title;
use app\modules\site\models\tools\Price;
use app\modules\order\models\entity\Order;
use app\modules\user\models\helpers\UserHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\OperatorAdmin\OperatorAdminWidget;

/* @var $this \yii\web\View
 * @var $orderQuery \yii\db\ActiveQuery
 * @var $user \app\modules\user\models\entity\User
 */

$this->title = Title::show('Кабинет оператора');
?>
<?= OperatorAdminWidget::widget(); ?>
<h5>Добро пожаловать, <?= UserHelper::getFullName($user); ?></h5>
<ul>
    <li>Всего обработано заказов: <?= $orderQuery->count(); ?></li>
    <li>
        Прибыль за месяц:
        <?php
        $result_summ = 0;
        foreach ($orderQuery->where(['is_paid' => true, 'is_close' => true, 'manager_id' => $user->id])
                     ->andWhere('created_at >= UNIX_TIMESTAMP(LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND created_at <  UNIX_TIMESTAMP(LAST_DAY(CURDATE()) + INTERVAL 1 DAY)')->all() as $order) {
            $result_summ += OrderHelper::orderSummary($order);
        }

        echo Price::format($result_summ) . '/<span class="green">' . Price::format(round($result_summ * 0.1)) . '</span>'
        ?>
    </li>
</ul>


<div class="operator-calculator-react"></div>