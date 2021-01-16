<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\group_buy\GroupBuyWidget;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\OrderStatus;

/* @var $model \app\modules\bonus\models\entity\UserBonusHistory
 * @var $this \yii\web\View
 * @var $availablePhones array
 */

$this->title = Title::showTitle("Меню: " . $model->name);
?>
    <div class="title-group">
        <h1>Меню: <?= $model->name; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'availablePhones' => $availablePhones,
    'form' => $form,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>