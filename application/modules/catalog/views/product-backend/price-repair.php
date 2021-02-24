<?php
/* @var $this \yii\web\View */

/* @var $models \app\modules\catalog\models\entity\Product[] */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<ul>
    <?php foreach ($models as $model): ?>
        <li>
            Цена: <?= $model->price; ?>
            Закупочная: <?= $model->purchase; ?>
            <?= Html::a($model->name, Url::to(['product-backend/update', 'id' => $model->id]), ['target' => '_blank']); ?>
        </li>
    <?php endforeach; ?>
</ul>
