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

/* @var $models array
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
                <?= $model->id; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>