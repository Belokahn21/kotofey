<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\GroupBuy\GroupBuyWidget;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\OrderStatus;

/* @var $model \app\modules\bonus\models\entity\UserBonusHistory
 * @var $this \yii\web\View
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $bonusAccount \app\modules\bonus\models\entity\UserBonus[]
 */

$this->title = Title::show("Начислено за: " . $model->reason);
?>
    <div class="title-group">
        <h1>Начислено за: <?= $model->reason; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
        <?= Html::a('Удалить', Url::to(['delete', 'id' => $model->id]), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'bonusAccount' => $bonusAccount,
    'orders' => $orders,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>