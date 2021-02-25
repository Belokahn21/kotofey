<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\group_buy\GroupBuyWidget;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\OrderStatus;

/* @var $models \app\modules\order\models\entity\Order[]
 */

$this->title = Title::show("Заказы");
?>
    <div class="title-group">
        <h1>Список доставок</h1>
    </div>

<?php if ($models): ?>
    <div class="logistic-list">
        <?php foreach ($models as $model): ?>
            <div class="logistic-list__item">
                Заказ #<?= $model->id; ?>
                Адрес доставки: <?= $model->city; ?>, <?= $model->street; ?>, д. <?= $model->number_home; ?>, кв. <?= $model->number_appartament; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>