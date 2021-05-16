<?php

use yii\helpers\Html;
use app\modules\catalog\models\helpers\ProductHelper;

/* @var $models \app\modules\catalog\models\entity\NotifyAdmission[] */
?>
<div class="user-admission">
    <?php foreach ($models as $model): ?>
        <div class="user-admission__item">
            Отслеживается поступление: <?= Html::a($model->product->name, ProductHelper::getDetailUrl($model->product)) ?>
        </div>
    <?php endforeach; ?>
</div>
